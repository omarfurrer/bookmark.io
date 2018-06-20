<?php

namespace App\Services\Categorization;

use App\Services\APIs\WebShrinkerClient;

class UrlCategoryDetector {

    /**
     * List of categories.
     * 
     * @var array 
     */
    protected $categories;

    /**
     * @var WebShrinkerClient 
     */
    protected $webshrinkerClient;

    /**
     * Constructor.
     * 
     * @param WebShrinkerClient $webshrinkerClient
     */
    public function __construct(WebShrinkerClient $webshrinkerClient)
    {
        $this->webshrinkerClient = $webshrinkerClient;
    }

    /**
     * Reset class.
     */
    public function reset()
    {
        $this->categories = [];
    }

    /**
     * Detect categories for a URL.
     * 
     * @param string $url
     * @param boolean $simple Detects IAB categories if set to false
     * @return array
     */
    public function detect($url, $simple = true)
    {
        $this->reset();
        $rawCategories = $this->webshrinkerClient->categorize($url, $simple);
        return $this->categories = $this->_parseRawCategories($rawCategories);
    }

    /**
     * Parse categories from raw response.
     * 
     * @param array $rawCategories
     * @return array
     */
    protected function _parseRawCategories($rawCategories)
    {
        return $rawCategories->data[0]->categories;
    }

    /**
     * Categories getter.
     * 
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

}
