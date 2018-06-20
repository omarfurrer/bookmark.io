<?php

namespace Tests\Unit\Services\Adult;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Adult\UrlAdultDetector;

class UrlAdultDetectorTest extends TestCase {

    /**
     * @var UrlAdultDetector 
     */
    protected $urlAdultDetector;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlAdultDetector = app()->make(UrlAdultDetector::class);
    }

    /**
     * Test non adult.
     */
    public function testNonAdultWebsitesTest()
    {
        $this->assertTrue(!$this->urlAdultDetector->detect("http://www.google.com"));
        $this->assertTrue(!$this->urlAdultDetector->detect("http://www.microsoft.com"));
        $this->assertTrue(!$this->urlAdultDetector->detect("http://www.youtube.com"));
    }

    /**
     * Test adult.
     */
    public function testAdultWebsitesTest()
    {
        $this->assertTrue($this->urlAdultDetector->detect("http://www.pornhub.com"));
        $this->assertTrue($this->urlAdultDetector->detect("http://www.redtube.com"));
        $this->assertTrue($this->urlAdultDetector->detect("http://www.xvideos.com"));
    }

}
