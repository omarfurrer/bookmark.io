<?php

namespace App\Repositories\Interfaces;

interface BookmarksRepositoryInterface {

    /**
     * Check if bookmark exists by its URL.
     * 
     * @param String $url
     * @return Boolean
     */
    public function existsByUrl($url);
}
