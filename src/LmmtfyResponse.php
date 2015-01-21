<?php
namespace Lmmtfy;

use GuzzleHttp\Client;

/**
 * This response class is returned when minifying using the synchronous API client class.
 * It defers the HTTP request until the minified content is requested and is able to
 * return the minified content as a string or write it to a file directly.
 */
class LmmtfyResponse
{
    /**
     * Client used to make the request
     *
     * @var \GuzzleHttp\Client
     */
    private $oClient;

    /**
     * Client URI to make the request to
     *
     * @var string
     */
    private $sUri;

    /**
     * Options used for minifing
     *
     * @var array
     */
    private $aMinifyOptions;

    /**
     * Content to minify
     *
     * @var string|resource
     */
    private $sContent;

    /**
     * Initialize a new LmmtfyResponse object
     *
     * @param \GuzzleHttp\Client $oClient        Client used to make the request
     * @param string             $sUri           Uri to make the request to
     * @param array              $aMinifyOptions Options used for minifing
     * @param string|resource    $sContent       Content to minify
     */
    public function __construct(Client $oClient, $sUri, array $aMinifyOptions, $sContent)
    {
        $this->oClient = $oClient;
        $this->sUri = $sUri;
        $this->aMinifyOptions = $aMinifyOptions;
        $this->sContent = $sContent;
    }

    /**
     * Makes a POST request to minify something
     *
     * @param array $aOptions
     *
     * @return \GuzzleHttp\Message\Response
     */
    private function call(array $aOptions = [])
    {
        $aOptions['body'] = $this->sContent;
        $aOptions['query'] = $this->aMinifyOptions;

        return $this->oClient->post($this->sUri, $aOptions);
    }

    /**
     * Minify and return as string
     *
     * @return string
     */
    public function toString()
    {
        return (string)$this->call()->getBody();
    }

    /**
     * Minify and save to file
     *
     * @param string|resource $sFile Filename or resource to save minified result to
     *
     * @return void
     */
    public function saveTo($sFile)
    {
        $this->call(['save_to' => $sFile]);
    }

    /**
     * Minify and return as string (wrapper for toString())
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
