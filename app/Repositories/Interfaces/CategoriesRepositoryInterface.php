<?php

namespace App\Repositories\Interfaces;

interface CategoriesRepositoryInterface {

    /**
     * Create a new category in the DB.
     * 
     * @param array $fields
     * @return mixed
     */
    public function create(array $fields = null);
}
