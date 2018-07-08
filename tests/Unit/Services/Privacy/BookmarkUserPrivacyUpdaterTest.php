<?php

namespace Tests\Unit\Services\Privacy;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Bookmark\BookmarkCreator;
use App\Services\Privacy\BookmarkUserPrivacyUpdater;
use App\Services\Bookmark\BookmarkUserAssociator;

class BookmarkUserPrivacyUpdaterTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var BookmarkUserPrivacyUpdater 
     */
    protected $bookmarkUserPrivacyUpdater;

    /**
     * @var BookmarkCreator 
     */
    protected $bookmarkCreator;

    /**
     * @var BookmarkUserAssociator 
     */
    protected $bookmarkUserAssociator;

    /**
     * Setting things up.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkUserPrivacyUpdater = resolve(BookmarkUserPrivacyUpdater::class);
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
        $this->bookmarkUserAssociator = resolve(BookmarkUserAssociator::class);
    }

    /**
     * Test updating bookmark user privacy.
     *
     * @return void
     */
    public function testUpdatingBookmarkUserPrivacy()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=WodNMNrZC30");
        $user = factory(\App\User::class)->create();

        $this->bookmarkUserAssociator->associate($bookmark, $user);

        $this->bookmarkUserPrivacyUpdater->updatePrivacy($bookmark, $user, true);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => true
        ]);

        $this->bookmarkUserPrivacyUpdater->updatePrivacy($bookmark, $user, false);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => false
        ]);
    }

}
