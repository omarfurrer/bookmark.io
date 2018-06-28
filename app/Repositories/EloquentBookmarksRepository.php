<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BookmarksRepositoryInterface;
use App\models\Bookmark;

class EloquentBookmarksRepository extends EloquentAbstractRepository implements BookmarksRepositoryInterface {

    /**
     * Bookmarks Repository constructor.
     */
    public function __construct()
    {
        $this->modelClass = Bookmark::class;
    }

    /**
     * Check if bookmark exists by its URL.
     * 
     * @param String $url
     * @return Boolean
     */
    public function existsByUrl($url)
    {
        return Bookmark::where('url', $url)->exists();
    }

}
