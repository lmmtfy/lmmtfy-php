<?php

namespace Lmmtfy;

use BadMethodCallException;
use InvalidArgumentException;

/**
 * This is the basic API client class. It is used to minify different types of files using the Lmmtfy API service.
 * @method LmmtfyResponse css(string | resource $content, array $options = []) Minify CSS
 * @method LmmtfyResponse js(string | resource $content, array $options = []) Minify JavaScript
 * @method LmmtfyResponse jpg(string | resource $content, array $options = []) Minify a JPEG image
 * @method LmmtfyResponse png(string | resource $content, array $options = []) Minify a PNG image
 * @method LmmtfyResponse gif(string | resource $content, array $options = []) Minify a GIF image
 * @method LmmtfyResponse svg(string | resource $content, array $options = []) Minify a SVG image
 */
class Lmmtfy extends ApiClient
{
    /**
     * Create a LmmtfyResponse object
     *
     * @param string          $uri     URI where the request should go to
     * @param string|resource $content Content to minify
     * @param array           $options Options used for minifing
     * @return LmmtfyResponse
     */
    private function getResponse(string $uri, $content, array $options = [])
    {
        return new LmmtfyResponse($this->client, $uri, $options, $content);
    }

    /**
     * Minify something
     *
     * @param string|resource $content Content to minify
     * @param array           $options Options used for minifing
     * @return LmmtfyResponse
     */
    public function minify($content, array $options = [])
    {
        return $this->getResponse('any', $content, $options);
    }

    /**
     * Magic method to handle rest of the types to minify
     *
     * @param string $type
     * @param array  $arguments
     * @return mixed
     * @throws BadMethodCallException
     * @throws InvalidArgumentException
     */
    public function __call(string $type, array $arguments)
    {
        if (!in_array($type, $this->validTypes)) {
            throw new BadMethodCallException('Unknown method ' . $type);
        }

        if (count($arguments) < 1) {
            throw new InvalidArgumentException('At least one argument required');
        }

        // Use type as first argument to call getResponse
        array_unshift($arguments, $type);

        return call_user_func_array([$this, 'getResponse'], $arguments);
    }
}
