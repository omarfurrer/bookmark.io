<?php

namespace App\Services\Categorization;

use App\models\Bookmark;
use App\Models\WebshrinkerIabCategory;
use App\Repositories\Interfaces\WebshrinkerIabCategoriesRepositoryInterface;
use App\Services\Categorization\BookmarkWsIabCategoryAssociator;

class BookmarkWsIabCategoriesAssociator {

    /**
     * @var WebshrinkerIabCategoriesRepositoryInterface 
     */
    protected $webshrinkerIabCategoriesRepository;

    /**
     * @var BookmarkWsIabCategoryAssociator 
     */
    protected $webshrinkerIabCategoryAssociator;

    /**
     * BookmarkWsIabCategoriesAssociator Constructor.
     * 
     * @param WebshrinkerIabCategoriesRepositoryInterface $webshrinkerIabCategoriesRepository
     * @param BookmarkWsIabCategoryAssociator $webshrinkerIabCategoryAssociator
     */
    public function __construct(WebshrinkerIabCategoriesRepositoryInterface $webshrinkerIabCategoriesRepository, BookmarkWsIabCategoryAssociator $webshrinkerIabCategoryAssociator)
    {
        $this->webshrinkerIabCategoriesRepository = $webshrinkerIabCategoriesRepository;
        $this->webshrinkerIabCategoryAssociator = $webshrinkerIabCategoryAssociator;
    }

    /**
     * Associate WS iab categories with bookmark.
     * 
     * @param Bookmark $bookmark
     * @param array $categories
     * @return Bookmark
     */
    public function associate(Bookmark $bookmark, $categories)
    {
        foreach ($categories as $category) {
            $bookmark = $this->webshrinkerIabCategoryAssociator->associate($bookmark, $this->getCategory((Object) $category));
        }
        return $bookmark;
    }

    /**
     * Get WS iab category model.
     * 
     * @param Object $category
     * @return type
     */
    public function getCategory($category)
    {
        return $this->webshrinkerIabCategoriesRepository->findBy($category->id, 'key');
    }

}
