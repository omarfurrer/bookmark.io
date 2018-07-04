<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoriesRepositoryInterface;
use App\Repositories\Interfaces\WebshrinkerIabCategoriesRepositoryInterface;
use App\models\WebshrinkerIabCategory;

class EloquentWebshrinkerIabCategoriesRepository extends EloquentAbstractRepository implements CategoriesRepositoryInterface, WebshrinkerIabCategoriesRepositoryInterface {

    /**
     * Webshrinker IAB categories Repository constructor.
     */
    public function __construct()
    {
        $this->modelClass = WebshrinkerIabCategory::class;
    }

}
