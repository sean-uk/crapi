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
    public function testNoAuthHeader()
    {
        // if the special 'Auth' header is not set, you'd not expect any modified behaviour
        $middleware = new SecretHeaderMiddleware();

        $request = Phake::mock(ServerRequestInterface::class);
        $delegate = Phake::mock(DelegateInterface::class);

        $middleware->process($request, $delegate);

        Phake::verify($delegate)->process($request);
    }
}