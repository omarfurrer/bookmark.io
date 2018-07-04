<?php

namespace Tests\Unit\Services\Categorization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Categorization\BookmarkWsSimpleCategoryAssociator;
use App\Services\Categorization\BookmarkWsSimpleCategoriesAssociator;
use App\Services\Categorization\BookmarkWsIabCategoryAssociator;
use App\Services\Categorization\BookmarkWsIabCategoriesAssociator;
use App\Services\Bookmark\BookmarkCreator;
use App\Repositories\Interfaces\WebshrinkerSimpleCategoriesRepositoryInterface;
use App\Repositories\Interfaces\WebshrinkerIabCategoriesRepositoryInterface;

class WebshrinkerCategoriesAssociatorsTest extends TestCase {

    /**
     * @var BookmarkWsSimpleCategoryAssociator 
     */
    protected $webshrinkerSimpleCategoryAssociator;

    /**
     * @var BookmarkWsSimpleCategoriesAssociator 
     */
    protected $wsSimpleCategoriesAssociator;

    /**
     * @var BookmarkWsIabCategoryAssociator 
     */
    protected $webshrinkerIabCategoryAssociator;

    /**
     * @var BookmarkWsIabCategoriesAssociator 
     */
    protected $wsIabCategoriesAssociator;

    /**
     * @var BookmarkCreator 
     */
    protected $bookmarkCreator;

    /**
     * @var WebshrinkerSimpleCategoriesRepositoryInterface 
     */
    protected $wsSimpleCategoriesRepository;

    /**
     * @var WebshrinkerIabCategoriesRepositoryInterface 
     */
    protected $wsIabCategoriesRepository;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerSimpleCategoryAssociator = resolve(BookmarkWsSimpleCategoryAssociator::class);
        $this->webshrinkerIabCategoryAssociator = resolve(BookmarkWsIabCategoryAssociator::class);
        $this->wsSimpleCategoriesAssociator = resolve(BookmarkWsSimpleCategoriesAssociator::class);
        $this->wsIabCategoriesAssociator = resolve(BookmarkWsIabCategoriesAssociator::class);
        $this->bookmarkCreator = resolve(BookmarkCreator::class);
        $this->wsSimpleCategoriesRepository = resolve(WebshrinkerSimpleCategoriesRepositoryInterface::class);
        $this->wsIabCategoriesRepository = resolve(WebshrinkerIabCategoriesRepositoryInterface::class);
    }

    /**
     * Test BookmarkWsSimpleCategoryAssociator.
     *
     * @return void
     */
    public function testSimpleCategoryAssociator()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $category = $this->wsSimpleCategoriesRepository->getById(39);
        $this->webshrinkerSimpleCategoryAssociator->associate($bookmark, $category);

        $this->assertDatabaseHas('bookmark_ws_s_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $category->id
        ]);

        $this->assertTrue($this->webshrinkerSimpleCategoryAssociator->bookmarkHasCategory($bookmark, $category));

        $category = $this->wsSimpleCategoriesRepository->getById(38);
        $this->assertFalse($this->webshrinkerSimpleCategoryAssociator->bookmarkHasCategory($bookmark, $category));
    }

    /**
     * Test BookmarkWsIabCategoryAssociator.
     *
     * @return void
     */
    public function testIabCategoryAssociator()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $category = $this->wsIabCategoriesRepository->getById(297);
        $this->webshrinkerIabCategoryAssociator->associate($bookmark, $category);

        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $category->id
        ]);

        $this->assertTrue($this->webshrinkerIabCategoryAssociator->bookmarkHasCategory($bookmark, $category));

        $category = $this->wsIabCategoriesRepository->getById(38);
        $this->assertFalse($this->webshrinkerIabCategoryAssociator->bookmarkHasCategory($bookmark, $category));
    }

    /**
     * Test BookmarkWsSimpleCategoriesAssociator.
     *
     * @return void
     */
    public function testSimpleCategoriesAssociator()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $categories = [
            [
                'id' => 'business',
                'label' => 'Business'
            ],
            [
                'id' => 'informationtech',
                'label' => 'Information Technology'
            ]
        ];

        $categoryModelOne = $this->wsSimpleCategoriesAssociator->getCategory((Object) $categories[0]);
        $categoryModelTwo = $this->wsSimpleCategoriesAssociator->getCategory((Object) $categories[1]);

        $this->assertEquals($categories[0]['id'], $categoryModelOne->key);

        $this->assertEquals($categories[1]['id'], $categoryModelTwo->key);

        $this->wsSimpleCategoriesAssociator->associate($bookmark, $categories);

        $this->assertDatabaseHas('bookmark_ws_s_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $categoryModelOne->id
                ]
        );
        $this->assertDatabaseHas('bookmark_ws_s_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $categoryModelTwo->id
                ]
        );
    }

    /**
     * Test BookmarkWsIabCategoriesAssociator.
     *
     * @return void
     */
    public function testIabCategoriesAssociator()
    {
        $bookmark = $this->bookmarkCreator->create("https://www.youtube.com/watch?v=cIUoMsV80r8");
        $categories = [
            [
                'confident' => true,
                'id' => 'IAB19',
                'label' => 'Technology & Computing',
                'parent' => 'IAB19',
                'score' => '0.855809166500086094'
            ],
            [
                'confident' => true,
                'id' => 'IAB19-14',
                'label' => 'Desktop Video',
                'parent' => 'IAB19',
                'score' => '0.855809166500086094'
            ]
        ];

        $categoryModelOne = $this->wsIabCategoriesAssociator->getCategory((Object) $categories[0]);
        $categoryModelTwo = $this->wsIabCategoriesAssociator->getCategory((Object) $categories[1]);

        $this->assertEquals($categories[0]['id'], $categoryModelOne->key);

        $this->assertEquals($categories[1]['id'], $categoryModelTwo->key);

        $this->wsIabCategoriesAssociator->associate($bookmark, $categories);

        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $categoryModelOne->id
                ]
        );
        $this->assertDatabaseHas('bookmark_ws_i_category', [
            'bookmark_id' => $bookmark->id,
            'category_id' => $categoryModelTwo->id
                ]
        );
    }

}
