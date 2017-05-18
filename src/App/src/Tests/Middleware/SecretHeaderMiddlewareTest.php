<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 17/05/2017
 * Time: 12:14
 */

namespace Tests\App\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use PHPUnit\Framework\TestCase;
use Phake;
use App\Middleware\SecretHeaderMiddleware;

class SecretHeaderMiddlewareTest extends TestCase
{
    /** @var SecretHeaderMiddleware $middleware */
    private $middleware;

    /** @var ServerRequestInterface $request */
    private $request;

    /** @var DelegateInterface $delegate */
    private $delegate;

    /**
     * Create a standard SUT and dependency mocks.
     */
    public function setUp()
    {
        $this->middleware = new SecretHeaderMiddleware();
        $this->request = Phake::mock(ServerRequestInterface::class);
        $this->delegate = Phake::mock(DelegateInterface::class);
    }

    public function testNoAuthHeader()
    {
        // if the special 'Auth' header is not set, you'd not expect any modified behaviour
        $this->middleware->process($this->request, $this->delegate);

        // verify the request has been passed on, that the middleware hasn't intervened.
        Phake::verify($this->delegate)->process($this->request);
        Phake::verifyNoFurtherInteraction($this->request);
    }

    public function testAuthHeaderEmpty()
    {
        // the header must have the string value 'false' to have any effect
        Phake::when($this->request)
            ->getHeader('Auth')
            ->thenReturn([]);

        $this->middleware->process($this->request, $this->delegate);

        // verify the request has been passed on, that the middleware hasn't intervened.
        Phake::verify($this->delegate)->process($this->request);
        Phake::verifyNoFurtherInteraction($this->request);
    }

    public function testAuthHeaderMisspelling()
    {
        // the header must have the exact string value 'false' to have any effect
        Phake::when($this->request)
            ->getHeader('Auth')
            ->thenReturn(['False']);

        $this->middleware->process($this->request, $this->delegate);

        Phake::verify($this->delegate)->process($this->request);
        Phake::verifyNoFurtherInteraction($this->request);
    }

    public function testAuthHeaderDeny()
    {
        // correct value, right case etc.
        Phake::when($this->request)
            ->getHeader('Auth')
            ->thenReturn(['false']);

        $response = $this->middleware->process($this->request, $this->delegate);

        // verify that the request is NOT delegated. And that something else is returned.
        Phake::verify($this->delegate, Phake::never())->process($this->request);
        $this->assertNotEquals($this->request, $response);
    }
}