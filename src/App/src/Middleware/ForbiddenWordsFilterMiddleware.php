<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 15/05/2017
 * Time: 10:30
 */

namespace App\Middleware;

use App\Stream\ReadCallbackStream;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Uri;
use Zend\Expressive\Router\RouteResult;
use Zend\Diactoros\Stream;
use GuzzleHttp\Psr7;
use Porter;
use Zend\Diactoros\Response\JsonResponse;

class ForbiddenWordsFilterMiddleware implements MiddlewareInterface
{
    /** @var array $forbidden_words */
    private $forbidden_words = [];

    public function __construct(array $forbiddenWords)
    {
        $this->forbidden_words = $forbiddenWords;

        // stem the words
        // @todo multilingual???
        foreach($this->forbidden_words as &$word) {
            $word = Porter::Stem($word);
        }

        // sort the words longest to shortest so they don't trip over each other
        usort($this->forbidden_words, function ($a, $b) {
            return strlen($b) - strlen($a);
        });
    }
    /**
     * Any 'forbidden words' in the body will be replaced by asterisks
     * Forbidden words in the prequest parameters will result in an error response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        // @see http://stackoverflow.com/a/38101818 for getting the route.
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);
        $matchedParams = $routeResult->getMatchedParams();

        // check each param matched in the route
        foreach ($matchedParams as $name=>$value) {
            if (
                $request->getAttribute($name, false)
                && $this->checkString($value)
            ) {
                $response = ['error'=>'Not allowed to use that as a name! Bye!!'];
                return new JsonResponse($response, 401);
            }
        }

        // clean up the body text
        $body = $request->getBody();

        // @todo this won't work so well if the read lengh happens to disect a forbidden word!
        $censorCallback = [$this, 'censorString'];
        $newBody = new ReadCallbackStream($body, $censorCallback);
        $request = $request->withBody($newBody);

        return $delegate->process($request);
    }

    /**
     * Check if there are any forbidden words in a string.
     *
     * @param string $string
     * @return bool
     */
    public function checkString($string)
    {
        foreach ($this->forbidden_words as $word) {
            if (stripos($string, $word)!==false) {
                return true;
            }
        }
        return false;
    }

    /**
     * remove the established forbidden words from a string, replacing them with asterisks
     * @param $string
     * @return string
     */
    public function censorString($string)
    {
        foreach ($this->forbidden_words as $word) {
            $replacement = str_repeat('*', strlen($word));
            $string = str_ireplace($word, $replacement, $string);
        }
        return $string;
    }
}