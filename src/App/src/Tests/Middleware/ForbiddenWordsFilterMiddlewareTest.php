<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 17/05/2017
 * Time: 15:16
 */

namespace Tests\App\Middleware;

use FastRoute\Route;
use GuzzleHttp\Psr7\BufferStream;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use PHPUnit\Framework\TestCase;
use Phake;
use App\Middleware\ForbiddenWordsFilterMiddleware;
use Psr\Http\Message\StreamInterface;
use Zend\Expressive\Router\RouteResult;

class ForbiddenWordsFilterMiddlewareTest extends TestCase
{
    /** @var ForbiddenWordsFilterMiddleware $middleware */
    private $middleware;

    /** @var ServerRequestInterface $request */
    private $request;

    /** @var DelegateInterface $delegate */
    private $delegate;

    /** @var RouteResult $route_result */
    private $route_result;

    /**
     * Create a standard SUT and dependency mocks.
     */
    public function setUp()
    {
        $this->middleware = new ForbiddenWordsFilterMiddleware(['badword']);
        $this->request = Phake::mock(ServerRequestInterface::class);
        $this->delegate = Phake::mock(DelegateInterface::class);

        // the class needs to know which route it matched. Create a fake result and tell the request to return that
        $this->route_result = Phake::mock(RouteResult::class);
        Phake::when($this->request)->getAttribute(RouteResult::class)->thenReturn($this->route_result);
        Phake::when($this->route_result)->getMatchedParams()->thenReturn([]);

        // return an empty body stream
        Phake::when($this->request)->getBody()->thenReturn(new BufferStream());

        // when try try to replace the body just return the same request as before.
        Phake::when($this->request)->withBody($this->anything())->thenReturn($this->request);
    }

    public function testNoForbiddenWords()
    {
        $middleware = new ForbiddenWordsFilterMiddleware([]);       // no forbidden words

        $middleware->process($this->request, $this->delegate);

        // the request shouldn't be intercepted
        Phake::verify($this->delegate, Phake::times(1))->process($this->request);
    }

    public function testForbiddenWordsInRoute()
    {
        Phake::when($this->route_result)->getMatchedParams()->thenReturn(['type'=>'badword']);
        Phake::when($this->request)->getAttribute('type', false)->thenReturn('badword');

        $this->middleware->process($this->request, $this->delegate);

        // the request should not be delegated.
        Phake::verify($this->delegate, Phake::never())->process($this->request);
    }

    public function testForbiddenWordsInBody()
    {
        $body = new BufferStream();
        $body->write('there is a badword in this sentence!');
        Phake::when($this->request)->getBody()->thenReturn($body);

        $this->middleware->process($this->request, $this->delegate);

        // request should be delegated, but the body should be altered.
        Phake::verify($this->delegate)->process($this->request);

        // verification by phpunit matcher: {@see http://phake.readthedocs.io/en/2.1/method-parameter-matchers.html#using-phpunit-matchers}
        // in this case \PHPUnit_Framework_Assert::callback
        Phake::verify($this->request)->withBody($this->callback(function (StreamInterface $stream) {
            // a little clumsy, but match my checking the string value of the stream is what you'd expect
            $string = (string)$stream;
            return ($string=='there is a ******* in this sentence!');
        }));
    }
}