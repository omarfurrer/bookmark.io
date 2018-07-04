<?php

namespace Tests\Unit\Services\Categorization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Categorization\BookmarkCategorizationHandler;
use App\Services\Bookmark\BookmarkCreator;

class BookmarkCategorizationHandlerTest extends TestCase {
    
    use RefreshDatabase;

    /**
     * @var BookmarkCategorizationHandler 
     */
    protected $bookmarkCategorizationHandler;

    /**
     * @var BookmarkCreator 
     */
    protected $bookmarkCreator;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bookmarkCategorizationHandler = resolve(BookmarkCategorizationHandler::class);
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
    }

    /**
     * Test WebshrinkerSimpleCategorizationHandler.
     *
     * @return void
     */
    public function testWebshrinkerSimpleCategorizationHandler()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $this->bookmarkCategorizationHandler->handleWsSimpleCategorization($bookmark);

        $this->assertDatabaseHas('bookmark_ws_s_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => 39
        ]);
    }

    /**
     * Test WebshrinkerIabCategorizationHandler.
     *
     * @return void
     */
    public function testWebshrinkerIabCategorizationHandler()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $this->bookmarkCategorizationHandler->handleWsIabCategorization($bookmark);

        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => 297
        ]);
        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => 311
        ]);
    }

}
