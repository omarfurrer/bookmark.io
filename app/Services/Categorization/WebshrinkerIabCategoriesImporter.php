<?php

namespace App\Services\Categorization;

use App\Services\APIs\WebShrinkerClient;
use App\Repositories\EloquentWebshrinkerSimpleCategoriesRepository;

class WebshrinkerSimpleCategoriesImporter extends AbstractCategoriesImporter {

    /**
     * Overriding constructor.
     * 
     * @param WebShrinkerClient $categoriesDownloader
     * @param EloquentWebshrinkerSimpleCategoriesRepository $categoriesRepository
     */
    public function __construct(WebShrinkerClient $categoriesDownloader, EloquentWebshrinkerSimpleCategoriesRepository $categoriesRepository)
    {
        parent::__construct($categoriesDownloader, $categoriesRepository);
    }

    /**
     * Parse the raw categories into an array of records to be inserted into DB.
     * 
     * @param $rawCategories
     * @return array 
     */
    public function parse($rawCategories)
    {
        $parsedCategories = [];
        $categories = $rawCategories->data->categories;
        foreach ($categories as $key => $name) {
            $parsedCategories[] = [
                'key' => $key,
                'value' => $name
            ];
        }
        return $parsedCategories;
    }

}
