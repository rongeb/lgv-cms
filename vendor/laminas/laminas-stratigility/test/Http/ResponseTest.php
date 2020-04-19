<?php

/**
 * @see       https://github.com/laminas/laminas-stratigility for the canonical source repository
 * @copyright https://github.com/laminas/laminas-stratigility/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-stratigility/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Stratigility\Http;

use Laminas\Diactoros\Response as PsrResponse;
use Laminas\Diactoros\Stream;
use Laminas\Stratigility\Http\Response;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Http\Message\StreamInterface;

class ResponseTest extends TestCase
{
    public $errorHandler;

    public function setUp()
    {
        $this->restoreErrorHandler();
        $this->errorHandler = function ($errno, $errstr) {
            return (false !== strstr($errstr, Response::class . ' is now deprecated'));
        };
        set_error_handler($this->errorHandler, E_USER_DEPRECATED);

        $this->original = new PsrResponse();
        $this->response = new Response($this->original);
    }

    public function tearDown()
    {
        $this->restoreErrorHandler();
    }

    public function restoreErrorHandler()
    {
        if ($this->errorHandler) {
            restore_error_handler();
            $this->errorHandler = null;
        }
    }

    public function testIsNotCompleteByDefault()
    {
        $this->assertFalse($this->response->isComplete());
    }

    public function testCallingEndMarksAsComplete()
    {
        $response = $this->response->end();
        $this->assertTrue($response->isComplete());
    }

    public function testWriteAppendsBody()
    {
        $this->response->write("First\n");
        $this->assertContains('First', (string) $this->response->getBody());
        $this->response->write("Second\n");
        $this->assertContains('First', (string) $this->response->getBody());
        $this->assertContains('Second', (string) $this->response->getBody());
    }

    /**
     * @dataProvider provideMutateMethods
     * @expectedException \RuntimeException
     */
    public function testCannotMutateResponseAfterCallingEnd($mutateMethod, $mutateMethodArgs)
    {
        $response = $this->response->withStatus(201);
        $response = $response->write("First\n");
        $response = $response->end('DONE');

        call_user_func_array([$response, $mutateMethod], $mutateMethodArgs);
    }

    public function provideMutateMethods()
    {
        return [
            ['withStatus', [200]],
            ['withHeader', ['X-Foo', 'Foo']],
            ['withAddedHeader', ['X-Foo', 'Foo']],
            ['withoutHeader', ['X-Foo']],
            ['withBody', [$this->prophesize('Psr\Http\Message\StreamInterface')->reveal()]],
            ['write', ['MOAR!']],
        ];
    }

    public function testCallingEndMultipleTimesDoesNothingAfterFirstCall()
    {
        $response = $this->response->end('foo');
        $response = $response->end('bar');
        $this->assertEquals('foo', (string) $response->getBody());
    }

    public function testCanAccessOriginalResponse()
    {
        $this->assertSame($this->original, $this->response->getOriginalResponse());
    }

    public function testDecoratorProxiesToAllMethods()
    {
        $this->assertEquals('1.1', $this->response->getProtocolVersion());

        $stream = $this->getMockBuilder('Psr\Http\Message\StreamInterface')->getMock();
        $response = $this->response->withBody($stream);
        $this->assertNotSame($this->response, $response);
        $this->assertSame($stream, $response->getBody());

        $this->assertSame($this->original->getHeaders(), $this->response->getHeaders());

        $response = $this->response->withHeader('Accept', 'application/xml');
        $this->assertNotSame($this->response, $response);
        $this->assertTrue($response->hasHeader('Accept'));
        $this->assertEquals('application/xml', $response->getHeaderLine('Accept'));

        $response = $this->response->withAddedHeader('X-URL', 'http://example.com/foo');
        $this->assertNotSame($this->response, $response);
        $this->assertTrue($response->hasHeader('X-URL'));

        $response = $this->response->withoutHeader('X-URL');
        $this->assertNotSame($this->response, $response);
        $this->assertFalse($response->hasHeader('X-URL'));

        $response = $this->response->withStatus(200, 'FOOBAR');
        $this->assertNotSame($this->response, $response);
        $this->assertEquals('FOOBAR', $response->getReasonPhrase());
    }
}
