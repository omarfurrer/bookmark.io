<?php

namespace App\Services\Categorization;

use App\Services\Categorization\CategoriesDownloaderInterface;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;

abstract class AbstractCategoriesImporter {

    /**
     * Used to download categories.
     * 
     * @var CategoriesDownloaderInterface 
     */
    protected $categoriesDownloader;

    /**
     * @var CategoriesRepositoryInterface 
     */
    protected $categoriesRepository;

    /**
     * Constructor.
     * 
     * @param CategoriesDownloaderInterface $categoriesDownloader
     * @param CategoriesRepositoryInterface $categoriesRepository
     */
    public function __construct(CategoriesDownloaderInterface $categoriesDownloader, CategoriesRepositoryInterface $categoriesRepository)
    {
        $this->categoriesDownloader = $categoriesDownloader;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Import categories to DB.
     */
    public function import()
    {
        $this->store($this->parse($this->fetch()));
    }

    /**
     * Fetch the categories to be parsed and stored.
     * 
     * @return array
     */
    protected function fetch()
    {
        return $this->categoriesDownloader->getCategories();
    }

    /**
     * Parse the raw categories into an array of records to be inserted into DB.
     * 
     * @param $rawCategories
     * @return array 
     */
    abstract function parse($rawCategories);

    /**
     * Store the parsed categories in DB.
     * 
     * @param array $categories
     */
    private function store($categories)
    {
        foreach ($categories as $category) {
            $this->categoriesRepository->create($category);
        }
    }

}
