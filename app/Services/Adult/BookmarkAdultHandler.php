<?php

namespace App\Services\Adult;

use App\models\Bookmark;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkAdultHandler {

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * @var UrlAdultDetector 
     */
    protected $urlAdultDetector;

    /**
     * BookmarkAdultHandler Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     * @param UrlAdultDetector $urlAdultDetector
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository, UrlAdultDetector $urlAdultDetector)
    {
        $this->bookmarksRepository = $bookmarksRepository;
        $this->urlAdultDetector = $urlAdultDetector;
    }

    /**
     * Handle adult flag for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handle(Bookmark $bookmark)
    {
        $isAdult = $this->checkAdult($bookmark);
        return $this->updateBookmarkAdult($bookmark, $isAdult);
    }

    /**
     * Check if a bookmark is of adult content.
     * 
     * @param Bookmark $bookmark
     * @return Boolean
     */
    public function checkAdult(Bookmark $bookmark)
    {
        return $this->urlAdultDetector->detect($bookmark->url);
    }

    /**
     * Update specific adult related attributes for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @param Boolean $isAdult
     * @return Bookmark
     */
    public function updateBookmarkAdult(Bookmark $bookmark, $isAdult)
    {
        return $this->bookmarksRepository->update($bookmark->id, [
                    'is_adult' => $isAdult
        ]);
    }

}
