<?php

namespace Tests\Unit\Services\Categorization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Categorization\WebshrinkerIabCategoriesImporter;

class WebshrinkerIabCategoriesImporterTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var WebshrinkerIabCategoriesImporter 
     */
    protected $webshrinkerIabCategoriesImporter;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerIabCategoriesImporter = app()->make(WebshrinkerIabCategoriesImporter::class);
    }

    /**
     * Test using the parse function. 
     */
    public function testParse()
    {
        $testObject = (object) ['data' => (object) ['categories' => ['IAB1' => [
                                'IAB1' => 'Arts & Entertainment',
                                'IAB1-1' => 'Books & Literature'
        ]]]];

        $intended = [
            ['key' => 'IAB1', 'value' => 'Arts & Entertainment', 'parent_key' => null],
            ['key' => 'IAB1-1', 'value' => 'Books & Literature', 'parent_key' => 'IAB1']
        ];

        $actual = $this->webshrinkerIabCategoriesImporter->parse($testObject);

        $this->assertEquals($intended, $actual);
    }

    /**
     * Test if class imports and stores in DB.
     */
    public function testImport()
    {
        $this->webshrinkerIabCategoriesImporter->import();
        $this->assertDatabaseHas('webshrinker_iab_categories', [
            'key' => 'IAB1',
            'value' => 'Arts & Entertainment',
            'parent_key' => null
        ]);
        $this->assertDatabaseHas('webshrinker_iab_categories', [
            'key' => 'IAB1-1',
            'value' => 'Books & Literature',
            'parent_key' => 'IAB1'
        ]);
        $this->assertDatabaseHas('webshrinker_iab_categories', [
            'key' => 'IAB10',
            'value' => 'Home & Garden',
            'parent_key' => null
        ]);
    }

}
