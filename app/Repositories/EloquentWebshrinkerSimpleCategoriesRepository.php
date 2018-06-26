<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoriesRepositoryInterface;
use App\Models\WebshrinkerSimpleCategory;

class EloquentWebshrinkerSimpleCategoriesRepository extends EloquentAbstractRepository implements CategoriesRepositoryInterface {

    /**
     * Webshrinker simple categories Repository constructor.
     */
    public function __construct()
    {
        $this->modelClass = WebshrinkerSimpleCategory::class;
    }

}
