<?php

namespace App\Services\Categorization;

use App\models\Bookmark;
use App\Models\WebshrinkerSimpleCategory;
use App\Repositories\Interfaces\WebshrinkerSimpleCategoriesRepositoryInterface;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkWsSimpleCategoryAssociator {

    /**
     * @var BookmarksRepositoryInterface
     */
    protected $bookmarksRepository;

    /**
     * @var WebshrinkerSimpleCategoriesRepositoryInterface 
     */
    protected $webshrinkerSimpleCategoriesRepository;

    /**
     * BookmarkWsSimpleCategoryAssociator Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     * @param WebshrinkerSimpleCategoriesRepositoryInterface $webshrinkerSimpleCategoriesRepository
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository, WebshrinkerSimpleCategoriesRepositoryInterface $webshrinkerSimpleCategoriesRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
        $this->webshrinkerSimpleCategoriesRepository = $webshrinkerSimpleCategoriesRepository;
    }

    /**
     * Associate WS simple category with bookmark.
     * 
     * @param Bookmark $bookmark
     * @param WebshrinkerSimpleCategory $category
     * @return Bookmark
     */
    public function associate(Bookmark $bookmark, WebshrinkerSimpleCategory $category)
    {
        if (!$this->bookmarkHasCategory($bookmark, $category)) {
            $bookmark = $this->bookmarksRepository->attachWsSimpleCategory($bookmark->id, $category->id);
        }
        return $bookmark;
    }

    /**
     * Check if bookmark already has category.
     * 
     * @param Bookmark $bookmark
     * @param WebshrinkerSimpleCategory $category
     * @return Boolean
     */
    public function bookmarkHasCategory(Bookmark $bookmark, WebshrinkerSimpleCategory $category)
    {
        return $this->bookmarksRepository->hasWsSimpleCategory($bookmark->id, $category->id);
    }

}
