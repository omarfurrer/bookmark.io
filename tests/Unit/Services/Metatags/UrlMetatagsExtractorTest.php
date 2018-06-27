<?php

namespace Tests\Unit\Services\Metatags;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Metatags\UrlMetatagsExtractor;
use App\Traits\EmojiRemoverTrait;

class UrlMetatagsExtractorTest extends TestCase {

    use EmojiRemoverTrait;

    /**
     * @var UrlMetatagsExtractor 
     */
    protected $urlMetatagsExtractor;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->urlMetatagsExtractor = app()->make(UrlMetatagsExtractor::class);
    }

    /**
     * Test extraction for URL with OG graph. 
     *
     * @return void
     */
    public function testOGTagsExtraction()
    {
        $metatags = $this->urlMetatagsExtractor->extract("https://www.youtube.com/watch?v=AZ1pHmWhIuY");

        $this->assertTrue(!empty($metatags));

        $this->assertEquals("‪The XX - Intro HQ‬‏ - YouTube", $this->removeEmojis($this->urlMetatagsExtractor->getTitle()));

        $this->assertTrue($this->urlMetatagsExtractor->openGraphDescriptionExists($metatags));

        $this->assertEquals("The XX - Intro HQ", $this->removeEmojis($this->urlMetatagsExtractor->getDescription()));

        $this->assertTrue($this->urlMetatagsExtractor->openGraphImageExists($metatags));

        $this->assertEquals("https://i.ytimg.com/vi/AZ1pHmWhIuY/hqdefault.jpg", $this->urlMetatagsExtractor->getImage());
    }

    /**
     * Test extraction for URL without OG graph.
     *
     * @return void
     */
    public function testNonOGTagsExtraction()
    {
        $metatags = $this->urlMetatagsExtractor->extract("https://tomato-timer.com/#");

        $this->assertTrue(!empty($metatags));

        $this->assertEquals("Tomato Timer", $this->removeEmojis($this->urlMetatagsExtractor->getTitle()));

        $this->assertTrue(!$this->urlMetatagsExtractor->openGraphDescriptionExists($metatags));

        $this->assertEquals("TomatoTimer is a flexible and easy to use online Pomodoro Technique Timer", $this->removeEmojis($this->urlMetatagsExtractor->getDescription()));

        $this->assertTrue(!$this->urlMetatagsExtractor->openGraphImageExists($metatags));

        $this->assertEquals(null, $this->urlMetatagsExtractor->getImage());
    }

}
