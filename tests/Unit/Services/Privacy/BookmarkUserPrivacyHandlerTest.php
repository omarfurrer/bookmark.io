<?php

namespace Tests\Unit\Services\Privacy;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Bookmark\BookmarkCreator;
use App\Services\Privacy\BookmarkUserPrivacyHandler;
use App\Services\Bookmark\BookmarkUserAssociator;
use App\Services\Adult\BookmarkAdultHandler;

class BookmarkUserPrivacyHandlerTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkUserPrivacyHandler 
     */
    protected $bookmarkUserPrivacyHandler;

    /**
     * @var BookmarkCreator 
     */
    protected $bookmarkCreator;

    /**
     * @var BookmarkUserAssociator 
     */
    protected $bookmarkUserAssociator;

    /**
     * @var BookmarkAdultHandler 
     */
    protected $bookmarkAdultHandler;

    /**
     * Setting things up.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkUserPrivacyHandler = resolve(BookmarkUserPrivacyHandler::class);
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
        $this->bookmarkUserAssociator = resolve(BookmarkUserAssociator::class);
        $this->bookmarkAdultHandler = resolve(BookmarkAdultHandler::class);
    }

    /**
     * Test updating bookmark user privacy.
     *
     * @return void
     */
    public function testHandlingBookmarkUserPrivacy()
    {
        $user = factory(\App\User::class)->create();

        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=WodNMNrZC30");

        $this->bookmarkUserAssociator->associate($bookmark, $user);

        $this->bookmarkAdultHandler->handle($bookmark);

        $this->bookmarkUserPrivacyHandler->handle($bookmark, $user);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => false
        ]);

        $bookmark = $this->bookmarkCreator->create("https://www.pornhub.com");

        $this->bookmarkUserAssociator->associate($bookmark, $user);

        $this->bookmarkAdultHandler->handle($bookmark);

        $this->bookmarkUserPrivacyHandler->handle($bookmark, $user);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => true
        ]);
    }

}
