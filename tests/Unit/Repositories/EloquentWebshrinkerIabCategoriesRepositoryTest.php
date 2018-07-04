<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\EloquentWebshrinkerIabCategoriesRepository;

class EloquentWebshrinkerIabCategoriesRepositoryTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var EloquentWebshrinkerIabCategoriesRepository 
     */
    protected $webshrinkerIabCategories;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerIabCategories = resolve(EloquentWebshrinkerIabCategoriesRepository::class);
    }

    /**
     * Test if create function works. 
     */
    public function testCreate()
    {
        $this->webshrinkerIabCategories->create([
            'key' => 'test',
            'value' => 'test'
        ]);

        $this->assertDatabaseHas('webshrinker_iab_categories', [
            'key' => 'test',
            'value' => 'test'
        ]);
    }

}
