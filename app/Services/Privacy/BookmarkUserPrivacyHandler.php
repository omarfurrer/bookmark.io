<?php

namespace App\Services\Privacy;

use App\models\Bookmark;
use App\User;
use App\Services\Privacy\BookmarkUserPrivacyUpdater;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkUserPrivacyHandler {

    /**
     * @var BookmarkUserPrivacyUpdater 
     */
    protected $bookmarkUserPrivacyUpdater;

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * BookmarkUserPrivacyHandler constructor.
     * 
     * @param BookmarkUserPrivacyUpdater $bookmarkUserPrivacyUpdater
     * @param BookmarksRepositoryInterface $bookmarksRepository
     */
    public function __construct(BookmarkUserPrivacyUpdater $bookmarkUserPrivacyUpdater, BookmarksRepositoryInterface $bookmarksRepository)
    {
        $this->bookmarkUserPrivacyUpdater = $bookmarkUserPrivacyUpdater;
        $this->bookmarksRepository = $bookmarksRepository;
    }

    /**
     * Handle user bookmark privacy.
     * 
     * @param Bookmark $bookmark
     * @param User $user
     * @return type
     */
    public function handle(Bookmark $bookmark, User $user)
    {
        $isPrivate = false;

        // get default privacy of bookmark
        // If is_adult is true, mark as private
        $isPrivate = $this->bookmarksRepository->isAdult($bookmark->id);

        // TODO : check global black list
        // TODO : check user black list


        return $this->bookmarkUserPrivacyUpdater->updatePrivacy($bookmark, $user, $isPrivate);
    }

}
