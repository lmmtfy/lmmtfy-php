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
     * @var \GuzzleHttp\Client
     */
    protected $oClient;

    /**
     * Valid types to minify
     *
     * @var array
     */
    protected $aValidTypes = [
        'css', 'js',
        'jpg', 'png', 'gif', 'svg',
    ];

    /**
     * Initialize a new API client
     *
     * @param string $sApiId     API ID
     * @param string $sApiSecret API secret
     * @param string $sEndpoint  Endpoint used for making API requests
     */
    public function __construct($sApiId = null, $sApiSecret = null, $sEndpoint = self::ENDPOINT)
    {
        $this->oClient = new Client([
            'base_url' => $sEndpoint,
            'defaults' => [
                'auth' => ($sApiId && $sApiSecret ? [$sApiId, $sApiSecret] : null),
            ]
        ]);
    }
}
