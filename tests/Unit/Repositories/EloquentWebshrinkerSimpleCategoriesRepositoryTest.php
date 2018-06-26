<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\EloquentWebshrinkerSimpleCategoriesRepository;

class EloquentWebshrinkerSimpleCategoriesRepositoryTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var EloquentWebshrinkerSimpleCategoriesRepository 
     */
    protected $webshrinkerSimpleCategories;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerSimpleCategories = resolve(EloquentWebshrinkerSimpleCategoriesRepository::class);
    }

    /**
     * Test if create function works. 
     */
    public function testCreate()
    {
        $this->webshrinkerSimpleCategories->create([
            'key' => 'test',
            'value' => 'test'
        ]);

        $this->assertDatabaseHas('webshrinker_simple_categories', [
            'key' => 'test',
            'value' => 'test'
        ]);
    }

}
