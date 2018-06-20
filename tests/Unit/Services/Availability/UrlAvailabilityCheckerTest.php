<?php

namespace Tests\Unit\Services\Availability;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Availability\UrlAvailabilityChecker;

class UrlAvailabilityCheckerTest extends TestCase {

    /**
     * @var UrlAvailabilityChecker 
     */
    protected $urlAvailabilityChecker;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlAvailabilityChecker = app()->make(UrlAvailabilityChecker::class);
    }

    /**
     * URL available test.
     *
     * @return void
     */
    public function testAvailableUrl()
    {
        $this->assertTrue($this->urlAvailabilityChecker->check("https://www.youtube.com/watch?v=DjtJJqYnW0I&index=140&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal"));
        $this->assertEquals($this->urlAvailabilityChecker->getCode(), 200);
        $this->assertEquals($this->urlAvailabilityChecker->getMessage(), "OK");
        $this->assertEquals($this->urlAvailabilityChecker->getIsAvailable(), TRUE);
    }

    /**
     * URL unavailable test.
     *
     * @return void
     */
    public function testUnavailableUrl()
    {
        $this->assertTrue(!$this->urlAvailabilityChecker->check("http://forbes.com/sites/dailymuse/2013/01/28/want-to-work-for-a-start-up"));
        $this->assertEquals($this->urlAvailabilityChecker->getCode(), 404);
        $this->assertEquals($this->urlAvailabilityChecker->getMessage(), "Not Found");
        $this->assertEquals($this->urlAvailabilityChecker->getIsAvailable(), FALSE);
    }

}
