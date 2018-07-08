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

    /**
     * Attach WS simple category to bookmark.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Bookmark
     */
    public function attachWsSimpleCategory($id, $categoryId)
    {
        $bookmark = $this->getById($id);
        $bookmark->wsSimpleCategories()->attach($categoryId);
        return $bookmark;
    }

    /**
     * Attach WS IAB category to bookmark.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Bookmark
     */
    public function attachWsIabCategory($id, $categoryId)
    {
        $bookmark = $this->getById($id);
        $bookmark->wsIabCategories()->attach($categoryId);
        return $bookmark;
    }

    /**
     * Checks whether a bookmark has a specific category.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Boolean
     */
    public function hasWsSimpleCategory($id, $categoryId)
    {
        $bookmark = $this->getById($id);
        return $bookmark->wsSimpleCategories()->where('webshrinker_simple_categories.id', $categoryId)->exists();
    }

    /**
     * Checks whether a bookmark has a specific category.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Boolean
     */
    public function hasWsIabCategory($id, $categoryId)
    {
        $bookmark = $this->getById($id);
        return $bookmark->wsIabCategories()->where('webshrinker_iab_categories.id', $categoryId)->exists();
    }

    /**
     * attach a bookmark to a user.
     * 
     * @param integer $id
     * @param integer $userId
     * @return Bookmark
     */
    public function attachUser($id, $userId)
    {
        $bookmark = $this->getById($id);
        $bookmark->users()->attach($userId);
        return $bookmark;
    }

    /**
     * Update user's bookmark privacy.
     * 
     * @param integer $id
     * @param integer $userId
     * @param Boolean $isPrivate
     * @return Bookmark
     */
    public function updateBookmarkPrivacy($id, $userId, $isPrivate = true)
    {
        $bookmark = $this->getById($id);
        $pivot = $bookmark->users()->where('users.id', $userId)->first();
        $pivot->pivot->is_private = $isPrivate;
        $pivot->pivot->save();
        return $bookmark;
    }

    /**
     * Check if a bookmark is adult content.
     * 
     * @param integer $id
     * @return boolean
     */
    public function isAdult($id)
    {
        $bookmark = $this->getById($id);
        return $bookmark->is_adult;
    }

}
