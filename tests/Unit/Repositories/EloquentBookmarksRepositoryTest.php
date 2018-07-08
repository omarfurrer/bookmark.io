<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\EloquentBookmarksRepository;

class EloquentBookmarksRepositoryTest extends TestCase {

    use RefreshDatabase;

    /**
     * @var EloquentBookmarksRepository 
     */
    protected $bookmarksRepository;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarksRepository = resolve(EloquentBookmarksRepository::class);
    }

    /**
     * Test basic functions. 
     */
    public function testBasicFunctionality()
    {
        $this->bookmarksRepository->create([
            'url' => 'https://www.youtube.com/watch?v=cIUoMsV80r8',
            'domain' => 'youtube.com'
        ]);

        $this->assertDatabaseHas('bookmarks', [
            'url' => 'https://www.youtube.com/watch?v=cIUoMsV80r8',
            'domain' => 'youtube.com'
        ]);

        $this->assertTrue($this->bookmarksRepository->existsByUrl("https://www.youtube.com/watch?v=cIUoMsV80r8"));
    }

    /**
     * Test basic functions. 
     */
    public function testCategorization()
    {
        $bookmark = $this->bookmarksRepository->create([
            'url' => 'https://www.youtube.com/watch?v=cIUoMsV80r8',
            'domain' => 'youtube.com'
        ]);

        $this->bookmarksRepository->attachWsSimpleCategory($bookmark->id, 1);

        $this->assertDatabaseHas('bookmark_ws_s_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => 1
        ]);

        $this->assertTrue($this->bookmarksRepository->hasWsSimpleCategory($bookmark->id, 1));
        $this->assertFalse($this->bookmarksRepository->hasWsSimpleCategory($bookmark->id, 2));

        $this->bookmarksRepository->attachWsIabCategory($bookmark->id, 1);

        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => 1
        ]);

        $this->assertTrue($this->bookmarksRepository->hasWsIabCategory($bookmark->id, 1));
        $this->assertFalse($this->bookmarksRepository->hasWsIabCategory($bookmark->id, 2));
    }

    /**
     * Test bookmak user attachement functions. 
     */
    public function testBookmarkUserAttachement()
    {
        $bookmark = $this->bookmarksRepository->create([
            'url' => 'https://www.youtube.com/watch?v=cIUoMsV80r8',
            'domain' => 'youtube.com'
        ]);

        $user = factory(\App\User::class)->create();

        $this->bookmarksRepository->attachUser($bookmark->id, $user->id);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => false
        ]);

        $this->bookmarksRepository->updateBookmarkPrivacy($bookmark->id, $user->id);

        $this->assertDatabaseHas("bookmark_user", [
            "user_id" => $user->id,
            "bookmark_id" => $bookmark->id,
            "is_private" => true
        ]);
    }

}
