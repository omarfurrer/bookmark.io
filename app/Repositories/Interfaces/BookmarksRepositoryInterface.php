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

    /**
     * Attach WS simple category to bookmark.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Bookmark
     */
    public function attachWsSimpleCategory($id, $categoryId);

    /**
     * Attach WS IAB category to bookmark.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Bookmark
     */
    public function attachWsIabCategory($id, $categoryId);

    /**
     * Checks whether a bookmark has a specific category.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Boolean
     */
    public function hasWsSimpleCategory($id, $categoryId);

    /**
     * Checks whether a bookmark has a specific category.
     * 
     * @param Integer $id
     * @param Integer $categoryId
     * @return Boolean
     */
    public function hasWsIabCategory($id, $categoryId);

    /**
     * attach a bookmark to a user.
     * 
     * @param integer $id
     * @param integer $userId
     * @return Bookmark
     */
    public function attachUser($id, $userId);
}
