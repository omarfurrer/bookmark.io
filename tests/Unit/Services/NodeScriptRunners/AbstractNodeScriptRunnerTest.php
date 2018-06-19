<?php

namespace Tests\Unit\Services\NodeScriptRunners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\NodeScriptRunners\AbstractNodeScriptRunner;

class AbstractNodeScriptRunnerTest extends TestCase {

    /**
     * @var UrlAvailabilityCheckNodeScriptRunner 
     */
    protected $nodeScriptRunner;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->nodeScriptRunner = $this->getMockForAbstractClass(AbstractNodeScriptRunner::class);
    }

    /**
     * Test converting from associative array to indexed array according to a mapping.
     */
    public function testconvertParamsFromAssociativeToIndexed()
    {
        $associativeArray = [
            'priority' => 'high',
            'url' => 'www.google.com',
            'queued' => false
        ];

        $mapping = [
            'url' => 0,
            'priority' => 1,
            'queued' => 2
        ];

        $indexedArray = $this->nodeScriptRunner->convertAssociativeToIndexedArray($associativeArray, $mapping);

        $intendedIndexedArray = ['www.google.com', 'high', false];

        $this->assertEquals($indexedArray, $intendedIndexedArray);
    }

    /**
     * Test adding indexed params to command.
     */
    public function testAddParamsToCommand()
    {
        $params = ['www.google.com', 'high', false , '20', 1];

        $command = "node execute.js anything";

        $command = $this->nodeScriptRunner->addArrayValuesToString($command, $params);

        $intendedCommand = "node execute.js anything www.google.com high false 20 1";

        $this->assertEquals($command, $intendedCommand);
    }

}
