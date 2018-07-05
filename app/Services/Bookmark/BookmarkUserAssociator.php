<?php

namespace App\Services\Bookmark;

use App\models\Bookmark;
use App\User;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;

class BookmarkUserAssociator {

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    /**
     * BookmarkUserAssociator Constructor.
     * 
     * @param BookmarksRepositoryInterface $bookmarksRepository
     */
    public function __construct(BookmarksRepositoryInterface $bookmarksRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
    }

    /**
     * Associate bookmark with a user.
     * 
     * @param Bookmark $bookmark
     * @param User $user
     * @return Bookmark
     */
    public function associate(Bookmark $bookmark, User $user)
    {
        return $this->bookmarksRepository->attachUser($bookmark->id, $user->id);
    }

}
