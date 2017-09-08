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
     * @var Client
     */
    private $client;

    /**
     * Client URI to make the request to
     *
     * @var string
     */
    private $uri;

    /**
     * Options used for minifing
     *
     * @var array
     */
    private $minifyOptions;

    /**
     * Content to minify
     *
     * @var string|resource
     */
    private $content;

    /**
     * Initialize a new LmmtfyResponse object
     *
     * @param \GuzzleHttp\Client $client        Client used to make the request
     * @param string             $uri           Uri to make the request to
     * @param array              $minifyOptions Options used for minifing
     * @param string|resource    $content       Content to minify
     */
    public function __construct(Client $client, string $uri, array $minifyOptions, $content)
    {
        $this->client = $client;
        $this->uri = $uri;
        $this->minifyOptions = $minifyOptions;
        $this->content = $content;
    }

    /**
     * Makes a POST request to minify something
     *
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function call(array $options = [])
    {
        $options['body'] = $this->content;
        $options['query'] = $this->minifyOptions;

        return $this->client->post($this->uri, $options);
    }

    /**
     * Minify and return as string
     *
     * @return string
     */
    public function toString()
    {
        return $this->call()->getBody()->getContents();
    }

    /**
     * Minify and save to file
     *
     * @param string|resource $file Filename or resource to save minified result to
     * @return void
     */
    public function saveTo($file)
    {
        $this->call(['save_to' => $file]);
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
