<?php

namespace Tests\Unit\Services\Adult;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Adult\BookmarkAdultHandler;
use App\models\Bookmark;

class BookmarkAdultHandlerTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkAdultHandler
     */
    protected $bookmarkAdultHandler;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkAdultHandler = app()->make(BookmarkAdultHandler::class);
    }

    /**
     * Bookmark available test.
     *
     * @return void
     */
    public function testNonAdultBookmark()
    {
        $bookmark = factory(Bookmark::class)->create(['url' => "https://www.youtube.com/watch?v=DjtJJqYnW0I&index=140&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal"]);
        $bookmark = $this->bookmarkAdultHandler->handle($bookmark);

        $this->assertArraySubset(["is_adult" => false], $bookmark->toArray());
        $this->assertDatabaseHas("bookmarks", [
            "id" => $bookmark->id,
            "is_adult" => false
        ]);
    }

    /**
     * Bookmark unavailable test.
     *
     * @return void
     */
    public function testAdultBookmark()
    {
        $bookmark = factory(Bookmark::class)->create(['url' => "http://pornhub.com"]);
        $bookmark = $this->bookmarkAdultHandler->handle($bookmark);

        $this->assertArraySubset(["is_adult" => true], $bookmark->toArray());
        $this->assertDatabaseHas("bookmarks", [
            "id" => $bookmark->id,
            "is_adult" => true
        ]);
    }

}
