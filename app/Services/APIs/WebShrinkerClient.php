<?php

namespace App\Services\APIs;

use GuzzleHttp\Client;
use App\Services\Laravel\WebShrinkerCredentials;

class WebShrinkerClient {

    CONST BASE_ENDPOINT = "https://api.webshrinker.com/";
    CONST CATEGORIZATION_ENDPOINT = "categories/";
    CONST API_VERSION = "v3";

    /**
     * Categorization taxonomies
     */
    CONST SIMPLE_CATEGORIZATION_TAXONOMY = "webshrinker";
    CONST IAB_CATEGORIZATION_TAXONOMY = "iabv1";

    /**
     * Request retries.
     */
    CONST RETRIES_DELTA_TIME = 10;
    CONST RETRIES_MAX = 3;

    /**
     * Guzzle client.
     * 
     * @var Client 
     */
    protected $guzzleClient;

    /**
     * Object holding web shrinker credentials.
     * 
     * @var WebShrinkerCredentials 
     */
    public $webshrinkerCredentials;

    /**
     * Constructor.
     * 
     * @param WebShrinkerCredentials $webshrinkerCredentials
     */
    public function __construct(WebShrinkerCredentials $webshrinkerCredentials)
    {
        $this->webshrinkerCredentials = $webshrinkerCredentials;
        $this->guzzleClient = new Client([
            'base_uri' => self::BASE_ENDPOINT,
            'auth' => [$this->webshrinkerCredentials->getKey(), $this->webshrinkerCredentials->getSecret()],
            'exceptions' => false
        ]);
    }

    /**
     * Get all possible categories either IAB or Webshrinker.
     * 
     * @param boolean $simple
     * @return array
     */
    public function getCategories($simple = true)
    {
        $endpoint = self::CATEGORIZATION_ENDPOINT . self::API_VERSION .
                '?taxonomy=' . ($simple ? self::SIMPLE_CATEGORIZATION_TAXONOMY : self::IAB_CATEGORIZATION_TAXONOMY);
        return $this->sendRequest($endpoint);
    }

    /**
     * Categorize a URL.
     * 
     * @param string $url
     * @param boolean $simple Indicates whether to use Simple Taxonomy or IAB Taxonomy.
     * @return array
     */
    public function categorize($url, $simple = true)
    {
        $endpoint = self::CATEGORIZATION_ENDPOINT . self::API_VERSION . '/' . $this->encodeUrl($url) .
                '?taxonomy=' . ($simple ? self::SIMPLE_CATEGORIZATION_TAXONOMY : self::IAB_CATEGORIZATION_TAXONOMY);
        return $this->sendRequest($endpoint);
    }

    /**
     * Send a request to web shrinker servers.
     * 
     * @param string $endpoint
     * @param string $method
     * @return array
     */
    public function sendRequest($endpoint, $method = 'GET')
    {
        $retries = 0;
        $code = null;

        // Perform retries if status == 200 The request is being categorized right now in real time, check again for an updated answer
        while ($retries <= self::RETRIES_MAX && ($code == null || $code == 202)) {
            sleep($retries * self::RETRIES_DELTA_TIME);

            $response = $this->guzzleClient->request($method, $endpoint);
            $code = $response->getStatusCode();

            $retries++;
        }

        if ($code != 200) {
            // LOG code / retries / url / endpoint
        }

        return json_decode($response->getBody());
    }

    /**
     * URL-safe base64 encoding
     * 
     * @param string $url
     * @return string
     */
    public function encodeUrl($url)
    {
        return str_replace(array('+', '/'), array('-', '_'), base64_encode($url));
    }

}
