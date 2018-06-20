<?php

namespace Tests\Unit\Services\NodeScriptRunners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\NodeScriptRunners\UrlAdultDetectorNodeScriptRunner;

class UrlAdultDetectorNodeScriptRunnerTest extends TestCase {

    /**
     * @var UrlAdultDetectorNodeScriptRunner 
     */
    protected $urlAdultDetectorNodeScriptRunner;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlAdultDetectorNodeScriptRunner = resolve(UrlAdultDetectorNodeScriptRunner::class);
    }

    /**
     * Test non adult.
     */
    public function testNonAdultWebsitesTest()
    {
        $this->assertTrue(!$this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.google.com']));
        $this->assertTrue(!$this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.microsoft.com']));
        $this->assertTrue(!$this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.youtube.com']));
    }

    /**
     * Test adult.
     */
    public function testAdultWebsitesTest()
    {
        $this->assertTrue($this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.pornhub.com']));
        $this->assertTrue($this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.redtube.com']));
        $this->assertTrue($this->urlAdultDetectorNodeScriptRunner->run(['url' => 'http://www.xvideos.com']));
    }

}
