<?php

namespace Tests\Unit\Services\Bookmark;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Bookmark\BookmarkCreator;

class BookmarkCreatorTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkCreator 
     */
    protected $bookmarkCreator;

    /**
     * Setting things up.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
    }

    /**
     * Testing creating bookmarks.
     *
     * @return void
     */
    public function testCreatingBookmark()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=WodNMNrZC30");
        $this->assertArraySubset(["url" => "https://www.youtube.com/watch?v=WodNMNrZC30", "domain" => "youtube.com"], $bookmark->toArray());
        $this->assertDatabaseHas("bookmarks", [
            "id" => $bookmark->id,
            "url" => "https://www.youtube.com/watch?v=WodNMNrZC30",
            "domain" => "youtube.com"
        ]);
    }

}
