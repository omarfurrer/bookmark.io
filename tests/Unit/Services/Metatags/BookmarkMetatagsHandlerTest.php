<?php

namespace Tests\Unit\Services\Availability;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Metatags\BookmarkMetatagsHandler;
use App\models\Bookmark;

class BookmarkMetatagsHandlerTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkMetatagsHandler 
     */
    protected $bookmarkMetatagsHandler;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkMetatagsHandler = app()->make(BookmarkMetatagsHandler::class);
    }

    /**
     * Bookmark available test.
     *
     * @return void
     */
    public function testHandleMetatagsExtractionBookmark()
    {
        $bookmark = factory(Bookmark::class)->create(["url" => "https://www.youtube.com/watch?v=cIUoMsV80r8"]);
        $bookmark = $this->bookmarkMetatagsHandler->handle($bookmark);

        $this->assertArraySubset([
            "title" => "‪Vikings - Soundtracks‬‏ - YouTube",
            "description" => "Garmarna - Herr Mannelig (00:00 - 05:55) Fever Ray - If I Had A Heart (05:56 - 09:43) Duivelspack - Völuspá (09:44 - 14:18) Einar Selvik - Leaving For Paris ...",
            "image" => "https://i.ytimg.com/vi/cIUoMsV80r8/maxresdefault.jpg"
                ], $bookmark->toArray());

        $this->assertDatabaseHas("bookmarks",
                                 [
            "id" => $bookmark->id,
            "title" => "‪Vikings - Soundtracks‬‏ - YouTube",
            "description" => "Garmarna - Herr Mannelig (00:00 - 05:55) Fever Ray - If I Had A Heart (05:56 - 09:43) Duivelspack - Völuspá (09:44 - 14:18) Einar Selvik - Leaving For Paris ...",
            "image" => "https://i.ytimg.com/vi/cIUoMsV80r8/maxresdefault.jpg"
        ]);
    }

}
