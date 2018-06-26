<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoriesRepositoryInterface;
use App\models\WebshrinkerIabCategory;

class EloquentWebshrinkerIabCategoriesRepository extends EloquentAbstractRepository implements CategoriesRepositoryInterface {

    /**
     * Webshrinker IAB categories Repository constructor.
     */
    public function __construct()
    {
        $this->modelClass = WebshrinkerIabCategory::class;
    }

}
