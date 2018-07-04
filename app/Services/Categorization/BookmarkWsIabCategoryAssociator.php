<?php

namespace App\Services\Categorization;

use App\models\Bookmark;
use App\Models\WebshrinkerIabCategory;
use App\Repositories\Interfaces\WebshrinkerIabCategoriesRepositoryInterface;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkWsIabCategoryAssociator {

    /**
     * @var BookmarksRepositoryInterface
     */
    protected $bookmarksRepository;

    /**
     * @var WebshrinkerIabCategoriesRepositoryInterface 
     */
    protected $webshrinkerIabCategoriesRepository;

    /**
     * BookmarkWsIabCategoryAssociator Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     * @param WebshrinkerIabCategoriesRepositoryInterface $webshrinkerIabCategoriesRepository
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository, WebshrinkerIabCategoriesRepositoryInterface $webshrinkerIabCategoriesRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
        $this->webshrinkerIabCategoriesRepository = $webshrinkerIabCategoriesRepository;
    }

    /**
     * Associate WS iab category with bookmark.
     * 
     * @param Bookmark $bookmark
     * @param WebshrinkerIabCategory $category
     * @return Bookmark
     */
    public function associate(Bookmark $bookmark, WebshrinkerIabCategory $category)
    {
        if (!$this->bookmarkHasCategory($bookmark, $category)) {
            $bookmark = $this->bookmarksRepository->attachWsIabCategory($bookmark->id, $category->id);
        }
        return $bookmark;
    }

    /**
     * Check if bookmark already has category.
     * 
     * @param Bookmark $bookmark
     * @param WebshrinkerIabCategory $category
     * @return Boolean
     */
    public function bookmarkHasCategory(Bookmark $bookmark, WebshrinkerIabCategory $category)
    {
        return $this->bookmarksRepository->hasWsIabCategory($bookmark->id, $category->id);
    }

}
