<?php

namespace App\Services\Laravel;

class WebShrinkerCredentials {

    /**
     * Webshrinker API key.
     * 
     * @var string 
     */
    protected $key;

    /**
     * Webshrinker API secret.
     * 
     * @var string 
     */
    protected $secret;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->key = config('services.webshrinker.key');
        $this->secret = config('services.webshrinker.secret');
    }

    /**
     * Key getter.
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Secret getter.
     * 
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

}
