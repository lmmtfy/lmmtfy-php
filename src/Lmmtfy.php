<?php
namespace Lmmtfy;

use BadMethodCallException;
use InvalidArgumentException;

/**
 * This is the basic API client class. It is used to minify different types of files using the Lmmtfy API service.
 *
 * @method LmmtfyResponse css(string|resource $sContent, array $aOptions = []) Minify CSS
 * @method LmmtfyResponse js(string|resource $sContent, array $aOptions = []) Minify JavaScript
 * @method LmmtfyResponse jpg(string|resource $sContent, array $aOptions = []) Minify a JPEG image
 * @method LmmtfyResponse png(string|resource $sContent, array $aOptions = []) Minify a PNG image
 * @method LmmtfyResponse gif(string|resource $sContent, array $aOptions = []) Minify a GIF image
 * @method LmmtfyResponse svg(string|resource $sContent, array $aOptions = []) Minify a SVG image
 */
class Lmmtfy extends ApiClient
{
    /**
     * Create a LmmtfyResponse object
     *
     * @param string          $sUri     URI where the request should go to
     * @param string|resource $sContent Content to minify
     * @param array           $aOptions Options used for minifing
     *
     * @return LmmtfyResponse
     */
    private function getResponse($sUri, $sContent, array $aOptions = [])
    {
        return new LmmtfyResponse($this->oClient, $sUri, $aOptions, $sContent);
    }

    /**
     * Minify something
     *
     * @param string|resource $sContent Content to minify
     * @param array           $aOptions Options used for minifing
     *
     * @return LmmtfyResponse
     */
    public function minify($sContent, array $aOptions = [])
    {
        return $this->getResponse('any', $sContent, $aOptions);
    }

    /**
     * Magic method to handle rest of the types to minify
     *
     * @throws BadMethodCallException If the type to minify is unknown
     * @throws InvalidArgumentException If no content is given
     *
     * @return LmmtfyResponse
     */
    public function __call($sType, array $aArguments)
    {
        if (!in_array($sType, $this->aValidTypes))
            throw new BadMethodCallException('Unknown method ' . $sType);

        if (count($aArguments) < 1)
            throw new InvalidArgumentException('One argument required');

        // Use type as first argument to call getResponse
        array_unshift($aArguments, $sType);

        return call_user_func_array(array($this, 'getResponse'), $aArguments);
    }
}
