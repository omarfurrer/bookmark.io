<?php

namespace App\Services\Availability;

use App\Repositories\Interfaces\BookmarksRepositoryInterface;
use App\models\Bookmark;
use Carbon\Carbon;

class BookmarkAvailabilityHandler {

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * @var UrlAvailabilityChecker 
     */
    protected $urlAvailabilityCheker;

    /**
     * BookmarkAvailabilityHandler Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     * @param UrlAvailabilityChecker $urlAvailabilityCheker
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository, UrlAvailabilityChecker $urlAvailabilityCheker)
    {
        $this->bookmarksRepository = $bookmarksRepository;
        $this->urlAvailabilityCheker = $urlAvailabilityCheker;
    }

    /**
     * Handle availability for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Bookmark
     */
    public function handle(Bookmark $bookmark)
    {
        $availability = $this->checkAvailability($bookmark);
        return $this->updateBookmarkAvailability($bookmark, !$availability, $this->urlAvailabilityCheker->getCode(), $this->urlAvailabilityCheker->getMessage(), Carbon::now());
    }

    /**
     * Check the availability of a bookmark.
     * 
     * @param Bookmark $bookmark
     * @return Boolean
     */
    public function checkAvailability(Bookmark $bookmark)
    {
        return $this->urlAvailabilityCheker->check($bookmark->url);
    }

    /**
     * Update specific availability related attributes for a bookmark.
     * 
     * @param Bookmark $bookmark
     * @param Boolean $isDead
     * @param Integer $httpCode
     * @param String $httpMessage
     * @param Carbon $lastAvailabilityCheckAt
     * @return Bookmark
     */
    public function updateBookmarkAvailability(Bookmark $bookmark, $isDead, $httpCode, $httpMessage, $lastAvailabilityCheckAt)
    {
        return $this->bookmarksRepository->update($bookmark->id,
                                                  [
                    'is_dead' => $isDead,
                    'http_code' => $httpCode,
                    'http_message' => $httpMessage,
                    'last_availability_check_at' => $lastAvailabilityCheckAt
        ]);
    }

}
