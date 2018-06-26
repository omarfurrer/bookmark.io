<?php

namespace App\Services\Categorization;

use App\Services\APIs\WebShrinkerClient;
use App\Repositories\EloquentWebshrinkerIabCategoriesRepository;

class WebshrinkerIabCategoriesImporter extends AbstractCategoriesImporter {

    /**
     * Overriding constructor.
     * 
     * @param WebShrinkerClient $categoriesDownloader
     * @param EloquentWebshrinkerIabCategoriesRepository $categoriesRepository
     */
    public function __construct(WebShrinkerClient $categoriesDownloader, EloquentWebshrinkerIabCategoriesRepository $categoriesRepository)
    {
        parent::__construct($categoriesDownloader, $categoriesRepository);
    }

    /**
     * Fetch the categories to be parsed and stored.
     * 
     * @return array
     */
    protected function fetch()
    {
        return $this->categoriesDownloader->getCategories(false);
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

        foreach ($categories as $parentKey => $set) {
            $index = 0;
            foreach ($set as $key => $value) {
                $parsedCategories[] = [
                    'key' => $key,
                    'value' => $value,
                    'parent_key' => $index == 0 ? null : $parentKey
                ];
                $index++;
            }
        }

        return $parsedCategories;
    }

}
