<?php

namespace Tests\Unit\Services\Categorization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Categorization\WebshrinkerSimpleCategoriesImporter;

class WebshrinkerSimpleCategoriesImporterTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var WebshrinkerSimpleCategoriesImporter 
     */
    protected $webshrinkerSimpleCategoriesImporter;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerSimpleCategoriesImporter = app()->make(WebshrinkerSimpleCategoriesImporter::class);
    }

    /**
     * Test using the parse function. 
     */
    public function testParse()
    {
        $testObject = (object) ['data' => (object) ['categories' => ['somekey' => 'somevalue']]];

        $intended = [['key' => 'somekey', 'value' => 'somevalue']];

        $actual = $this->webshrinkerSimpleCategoriesImporter->parse($testObject);

        $this->assertEquals($intended, $actual);
    }

    /**
     * Test if class imports and stores in DB.
     */
    public function testImport()
    {
        $this->webshrinkerSimpleCategoriesImporter->import();
        $this->assertDatabaseHas('webshrinker_simple_categories', [
            'key' => 'advertising',
            'value' => 'Advertising'
        ]);
        $this->assertDatabaseHas('webshrinker_simple_categories', [
            'key' => 'entertainment',
            'value' => 'Entertainment'
        ]);
        $this->assertDatabaseHas('webshrinker_simple_categories', [
            'key' => 'shopping',
            'value' => 'Shopping'
        ]);
    }

}
