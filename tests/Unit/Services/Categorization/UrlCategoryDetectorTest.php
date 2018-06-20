<?php

namespace Tests\Unit\Services\Categorization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Categorization\UrlCategoryDetector;

class UrlCategoryDetectorTest extends TestCase {

    /**
     * @var UrlCategoryDetector 
     */
    protected $urlCategoryDetector;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlCategoryDetector = app()->make(UrlCategoryDetector::class);
    }

    /**
     * Test URL simple categorization.
     *
     * @return void
     */
    public function testSimpleCategorization()
    {
        $this->assertTrue(!empty($this->urlCategoryDetector->detect("https://www.youtube.com/watch?v=PXSVqk4YRAk&index=135&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal")));
    }

    /**
     * Test URL IAB categorization.
     *
     * @return void
     */
    public function testIabCategorization()
    {
        $this->assertTrue(!empty($this->urlCategoryDetector->detect("https://www.youtube.com/watch?v=PXSVqk4YRAk&index=135&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal", False)));
    }

}
