<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 16/05/2017
 * Time: 15:13
 */

namespace App\Stream;

use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;

class ReadCallbackStream implements StreamInterface
{
    // never seen this syntax before, but it's based on this: http://stackoverflow.com/a/12478210
    use StreamDecoratorTrait {
        StreamDecoratorTrait::__construct as private __constructDecorator;
    }

    /** @var callable $callback */
    private $callback;

    /**
     * ReadCallbackStream constructor.
     * @param StreamInterface $stream
     * @param callable|null $callable the vale read from the stream will be passed through this callable before being returned.
     */
    public function __construct(StreamInterface $stream, callable $callable = null)
    {
        $this->__constructDecorator($stream);
        $this->callback = $callable;
    }

    /**
     * @param int $length
     * @return mixed|string
     */
    public function read($length)
    {
        $string = $this->stream->read($length);
        if ($string && $this->callback) {
            $string = call_user_func($this->callback, $string);
        }
        return $string;
    }
}