<?php

namespace Tests\Unit\Services\NodeScriptRunners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\NodeScriptRunners\UrlAvailabilityCheckNodeScriptRunner;

class UrlAvailabilityCheckNodeScriptRunnerTest extends TestCase {

    /**
     * @var UrlAvailabilityCheckNodeScriptRunner 
     */
    protected $urlAvailabilityNodeScriptRunner;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlAvailabilityNodeScriptRunner = resolve(UrlAvailabilityCheckNodeScriptRunner::class);
    }

    /**
     * Test 200 ok response.
     */
    public function testUrlAvailabilityCheckSuccessTest()
    {
        $intended = [
            'error' => false,
            'code' => 200,
            'message' => 'OK'
        ];
        $result = (array) $this->urlAvailabilityNodeScriptRunner->run(['url' => 'https://www.google.com/']);
        $this->assertEquals($intended, $result);
    }

    /**
     * Test 404 Not Found response.
     */
    public function testUrlAvailabilityCheckFailTest()
    {
        $intended = [
            'error' => true,
            'code' => 404,
            'message' => 'Not Found'
        ];
        $result = (array) $this->urlAvailabilityNodeScriptRunner->run(['url' => 'https://www.forbes.com/sites/dailymuse/2013/01/28/want-to-work-for-a-start-']);
        $this->assertEquals($intended, $result);
    }

}
