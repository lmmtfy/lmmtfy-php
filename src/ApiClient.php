<?php

namespace Lmmtfy;

use GuzzleHttp\Client;

/**
 * This class is the base class for the Lmmtfy PHP API.
 * It is used to initialize the Guzzle client and set the API credentials and the API endpoint.
 */
abstract class ApiClient
{
    /**
     * Default API endpoint, the base URL where all requests will go to
     */
    const ENDPOINT = 'https://lmmtfy.io/v1/';

    /**
     * Client used to make requests
     *
     * @var Client
     */
    protected $client;

    /**
     * Valid types to minify
     *
     * @var string[]
     */
    protected $validTypes = [
        'css', 'js', 'jpg', 'png',
    ];

    /**
     * Initialize a new API client
     *
     * @param string $apiId     API ID
     * @param string $apiSecret API secret
     * @param string $endpoint  Endpoint used for making API requests
     */
    public function __construct(string $apiId = null, string $apiSecret = null, string $endpoint = self::ENDPOINT)
    {
        $this->client = new Client([
            'base_uri' => $endpoint,
            'auth'     => ($apiId && $apiSecret ? [$apiId, $apiSecret] : null),
        ]);
    }
}
