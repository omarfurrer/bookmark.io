<?php

namespace Tests\Unit\Services\Availability;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Availability\BookmarkAvailabilityHandler;
use App\models\Bookmark;

class BookmarkAvailabilityHandlerTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkAvailabilityHandler 
     */
    protected $bookmarkAvailabilityHandler;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkAvailabilityHandler = app()->make(BookmarkAvailabilityHandler::class);
    }

    /**
     * Bookmark available test.
     *
     * @return void
     */
    public function testAvailableBookmark()
    {
        $bookmark = factory(Bookmark::class)->create(['url' => "https://www.youtube.com/watch?v=DjtJJqYnW0I&index=140&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal"]);
        $bookmark = $this->bookmarkAvailabilityHandler->handle($bookmark);
        $this->assertArraySubset(["is_dead" => false, "http_code" => 200, "http_message" => "OK"], $bookmark->toArray());
        $this->assertNotNull($bookmark->last_availability_check_at);
        $this->assertDatabaseHas("bookmarks", [
            "id" => $bookmark->id,
            "is_dead" => false,
            "http_code" => 200,
            "http_message" => "OK"
        ]);
    }

    /**
     * Bookmark unavailable test.
     *
     * @return void
     */
    public function testUnavailableBookmark()
    {
        $bookmark = factory(Bookmark::class)->create(['url' => "http://forbes.com/sites/dailymuse/2013/01/28/want-to-work-for-a-start-up"]);
        $bookmark = $this->bookmarkAvailabilityHandler->handle($bookmark);
        $this->assertArraySubset(["is_dead" => true, "http_code" => 404, "http_message" => "Not Found"], $bookmark->toArray());
        $this->assertNotNull($bookmark->last_availability_check_at);
        $this->assertDatabaseHas("bookmarks", [
            "id" => $bookmark->id,
            "is_dead" => true,
            "http_code" => 404,
            "http_message" => "Not Found"
        ]);
    }

}
