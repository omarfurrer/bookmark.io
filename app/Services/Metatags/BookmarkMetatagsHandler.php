<?php

namespace App\Services\Metatags;

use App\Repositories\Interfaces\BookmarksRepositoryInterface;
use App\models\Bookmark;
use App\Services\Metatags\UrlMetatagsExtractor;

class BookmarkMetatagsHandler {

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * @var UrlMetatagsExtractor 
     */
    protected $urlMetatagsExtractor;

    /**
     * BookmarkMetatagsHandler Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     * @param UrlMetatagsExtractor $urlMetatagsExtractor
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository, UrlMetatagsExtractor $urlMetatagsExtractor)
    {
        $this->bookmarksRepository = $bookmarksRepository;
        $this->urlMetatagsExtractor = $urlMetatagsExtractor;
    }

    /**
     * Handle metatags for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handle(Bookmark $bookmark)
    {
        $metatags = $this->extractMetatags($bookmark);
        return $this->updateBookmarkMetatags($bookmark, $metatags, $this->urlMetatagsExtractor->getTitle(), $this->urlMetatagsExtractor->getDescription(), $this->urlMetatagsExtractor->getImage());
    }

    /**
     * Extract meta tags for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Object
     */
    public function extractMetatags(Bookmark $bookmark)
    {
        return $this->urlMetatagsExtractor->extract($bookmark->url);
    }

    /**
     * Update specific metatags related attributes for a bookmark.
     * Updates title, description and image as well.
     * 
     * @param Bookmark $bookmark
     * @param Object $metatags
     * @param String $title
     * @param String $description
     * @param String $image
     * @return Bookmark
     */
    public function updateBookmarkMetatags(Bookmark $bookmark, $metatags, $title, $description, $image)
    {
        return $this->bookmarksRepository->update($bookmark->id,
                                                  [
                    'metatags' => $metatags,
                    'title' => $title,
                    'description' => $description,
                    'image' => $image
        ]);
    }

}
