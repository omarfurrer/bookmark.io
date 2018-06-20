<?php

namespace Tests\Unit\Services\NodeScriptRunners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\NodeScriptRunners\UrlMetatagsExtractorNodeScriptRunner;

class UrlMetatagsExtractorNodeScriptRunnerTest extends TestCase {

    /**
     * @var UrlMetatagsExtractorNodeScriptRunner 
     */
    protected $urlMetatagsExtractorNodeScriptRunner;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlMetatagsExtractorNodeScriptRunner = resolve(UrlMetatagsExtractorNodeScriptRunner::class);
    }

    /**
     * Test that extracting meta tags returns a non empty array.
     */
    public function testMetatagsExtraction()
    {
        $this->assertTrue(!empty($this->urlMetatagsExtractorNodeScriptRunner->run([
                            'url' => 'https://www.youtube.com/watch?v=Gdg5HqX_vZE&index=26&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal'
        ])));
    }

}
