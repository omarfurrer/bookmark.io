<?php

namespace Tests\Unit\Services\Bookmark;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Bookmark\BookmarkUserAssociator;
use App\Services\Bookmark\BookmarkCreator;

class BookmarkUserAssociatorTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkUserAssociator 
     */
    protected $bookmarkUserAssociator;

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
        $this->bookmarkUserAssociator = resolve(BookmarkUserAssociator::class);
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
    }

    /**
     * Testing creating bookmarks.
     *
     * @return void
     */
    public function testAssociatingBookmarkToUser()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=WodNMNrZC30");
        $user = factory(\App\User::class)->create();

        $this->bookmarkUserAssociator->associate($bookmark, $user);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id
        ]);
    }

}
