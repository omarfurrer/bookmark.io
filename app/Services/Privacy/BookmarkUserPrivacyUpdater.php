<?php

namespace App\Services\Privacy;

use App\models\Bookmark;
use App\User;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkUserPrivacyUpdater {

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * BookmarkUserPrivacyUpdater constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
    }

    /**
     * Update privacy of a user's bookmark.
     * 
     * @param Bookmark $bookmark
     * @param User $user
     * @param Boolean $isPrivate
     * @return Bookmark
     */
    public function updatePrivacy(Bookmark $bookmark, User $user, $isPrivate = true)
    {
        return $this->bookmarksRepository->updateBookmarkPrivacy($bookmark->id, $user->id, $isPrivate);
    }

}
