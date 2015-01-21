<?php
namespace Lmmtfy;

use BadMethodCallException;
use InvalidArgumentException;
use GuzzleHttp\Message\Response;

/**
 * This is the async API client class. It is used to minify different types of files using the Lmmtfy API service
 * and uses asynchronous requests to do so.
 *
 * @method void css(string|resource $sContent, callable $oCallback) Minify CSS
 * @method void js(string|resource $sContent, callable $oCallback) Minify JavaScript
 * @method void jpg(string|resource $sContent, callable $oCallback) Minify a JPEG image
 * @method void png(string|resource $sContent, callable $oCallback) Minify a PNG image
 * @method void gif(string|resource $sContent, callable $oCallback) Minify a GIF image
 * @method void svg(string|resource $sContent, callable $oCallback) Minify a SVG image
 */
class Async extends ApiClient
{
    /**
     * Make an async request to minify some content
     *
     * @param string          $sUri           URI where the request should go to
     * @param string|resource $sContent       Content to minify
     * @param callable        $oCallback      Callback to call when the content is minified
     * @param array           $aMinifyOptions Options used for minifing
     */
    private function call($sUri, $sContent, callable $oCallback, array $aMinifyOptions = [])
    {
        $this->oClient->post($sUri, [
            'future' => true,
            'body'   => $sContent,
            'query'  => $aMinifyOptions,
        ])->then(function (Response $oResponse) use ($oCallback) {
            $oCallback((string)$oResponse->getBody());
        });
    }

    /**
     * Minify something
     *
     * @param string|resource $sContent       Content to minify
     * @param callable        $oCallback      Callback to call when the content is minified
     * @param array           $aMinifyOptions Options used for minifing
     *
     * @return Async
     */
    public function minify($sContent, callable $oCallback, array $aMinifyOptions = [])
    {
        $this->call('any', $sContent, $oCallback, $aMinifyOptions);

        return $this;
    }

    /**
     * Magic method to handle rest of the types to minify
     *
     * @throws BadMethodCallException If the type to minify is unknown
     * @throws InvalidArgumentException If no content is given
     */
    public function __call($sType, array $aArguments)
    {
        if (!in_array($sType, $this->aValidTypes))
            throw new BadMethodCallException('Unknown method ' . $sType);

        if (count($aArguments) < 2)
            throw new InvalidArgumentException('Two argument required');

        // Use type as first argument to call getResponse
        array_unshift($aArguments, $sType);
        call_user_func_array(array($this, 'call'), $aArguments);

        // Used for method chaining
        return $this;
    }
}
