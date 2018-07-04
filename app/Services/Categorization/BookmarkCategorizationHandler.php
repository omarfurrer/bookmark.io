<?php

namespace App\Services\Categorization;

use App\models\Bookmark;
use App\Services\Categorization\UrlCategoryDetector;
use App\Services\Categorization\BookmarkWsSimpleCategoriesAssociator;

class BookmarkCategorizationHandler {

    /**
     * @var UrlCategoryDetector 
     */
    protected $urlCategoryDetector;

    /**
     * @var BookmarkWsSimpleCategoriesAssociator 
     */
    protected $wsSimpleCategoriesAssociator;

    /**
     * @var BookmarkWsIabCategoriesAssociator 
     */
    protected $wsIabCategoriesAssociator;

    /**
     * BookmarkCategorizationHandler Constructor.
     * 
     * @param UrlCategoryDetector $urlCategoryDetector
     * @param BookmarkWsSimpleCategoriesAssociator $wsSimpleCategoriesAssociator
     * @param BookmarkWsIabCategoriesAssociator $wsIabCategoriesAssociator
     */
    public function __construct(UrlCategoryDetector $urlCategoryDetector, BookmarkWsSimpleCategoriesAssociator $wsSimpleCategoriesAssociator,
            BookmarkWsIabCategoriesAssociator $wsIabCategoriesAssociator)
    {
        $this->urlCategoryDetector = $urlCategoryDetector;
        $this->wsSimpleCategoriesAssociator = $wsSimpleCategoriesAssociator;
        $this->wsIabCategoriesAssociator = $wsIabCategoriesAssociator;
    }

    /**
     * Handle all categorization for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handle(Bookmark $bookmark)
    {
        $bookmark = $this->handleWsSimpleCategorization($bookmark);
        $bookmark = $this->handleWsIabCategorization($bookmark);
        return $bookmark;
    }

    /**
     * Handle Webshrinker Simple categorization.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handleWsSimpleCategorization(Bookmark $bookmark)
    {
        $categories = $this->urlCategoryDetector->detect($bookmark->url);
        return $this->wsSimpleCategoriesAssociator->associate($bookmark, $categories);
    }

    /**
     * Handle Webshrinker Iab categorization.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handleWsIabCategorization(Bookmark $bookmark)
    {
        $categories = $this->urlCategoryDetector->detect($bookmark->url, false);
        return $this->wsIabCategoriesAssociator->associate($bookmark, $categories);
    }

}
