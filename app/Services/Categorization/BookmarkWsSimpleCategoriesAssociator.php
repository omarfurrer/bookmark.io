<?php

namespace App\Services\Categorization;

use App\models\Bookmark;
use App\Models\WebshrinkerSimpleCategory;
use App\Repositories\Interfaces\WebshrinkerSimpleCategoriesRepositoryInterface;
use App\Services\Categorization\BookmarkWsSimpleCategoryAssociator;

class BookmarkWsSimpleCategoriesAssociator {

    /**
     * @var WebshrinkerSimpleCategoriesRepositoryInterface 
     */
    protected $webshrinkerSimpleCategoriesRepository;

    /**
     * @var BookmarkWsSimpleCategoryAssociator 
     */
    protected $webshrinkerSimpleCategoryAssociator;

    /**
     * BookmarkWsSimpleCategoriesAssociator Constructor.
     * 
     * @param WebshrinkerSimpleCategoriesRepositoryInterface $webshrinkerSimpleCategoriesRepository
     * @param BookmarkWsSimpleCategoryAssociator $webshrinkerSimpleCategoryAssociator
     */
    public function __construct(WebshrinkerSimpleCategoriesRepositoryInterface $webshrinkerSimpleCategoriesRepository, BookmarkWsSimpleCategoryAssociator $webshrinkerSimpleCategoryAssociator)
    {
        $this->webshrinkerSimpleCategoriesRepository = $webshrinkerSimpleCategoriesRepository;
        $this->webshrinkerSimpleCategoryAssociator = $webshrinkerSimpleCategoryAssociator;
    }

    /**
     * Associate WS simple categories with bookmark.
     * 
     * @param Bookmark $bookmark
     * @param array $categories
     * @return Bookmark
     */
    public function associate(Bookmark $bookmark, $categories)
    {
        foreach ($categories as $category) {
            $bookmark = $this->webshrinkerSimpleCategoryAssociator->associate($bookmark, $this->getCategory((Object) $category));
        }
        return $bookmark;
    }

    /**
     * Get WS simple category model.
     * 
     * @param Object $category
     * @return type
     */
    public function getCategory($category)
    {
        return $this->webshrinkerSimpleCategoriesRepository->findBy($category->id, 'key');
    }

}
