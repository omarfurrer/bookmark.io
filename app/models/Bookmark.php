<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookmarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["url", "title", "description", "image", "domain", "is_dead", "http_code", "http_message", "last_availability_check_at",
        "is_adult", "metatags"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'last_availability_check_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_dead' => 'boolean',
        'is_adult' => 'boolean',
        'metatags' => 'array'
    ];

    /**
     * A bookmark has many WS simple categories.
     *
     * @return BelongsToMany
     */
    public function wsSimpleCategories()
    {
        return $this->belongsToMany('App\models\WebshrinkerSimpleCategory', 'bookmark_ws_s_category', 'bookmark_id', 'category_id')->withTimestamps();
    }

    /**
     * A bookmark has many WS IAB categories.
     *
     * @return BelongsToMany
     */
    public function wsIabCategories()
    {
        return $this->belongsToMany('App\models\WebshrinkerIabCategory', 'bookmark_ws_i_category', 'bookmark_id', 'category_id')->withTimestamps();
    }

    /**
     * A bookmark belongs to many users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('is_private')->withTimestamps();
    }

}
