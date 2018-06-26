<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class WebshrinkerIabCategory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'webshrinker_iab_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["key", "value", "parent_key"];

}
