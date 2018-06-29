<?php

namespace App\Services\Bookmark;

use App\Traits\DomainExtractorTrait;
use App\Repositories\Interfaces\BookmarksRepositoryInterface;
use App\models\Bookmark;

class BookmarkCreator {

    use DomainExtractorTrait;

    /**
     * @var BookmarksRepositoryInterface 
     */
    protected $bookmarksRepository;

    public function __construct(BookmarksRepositoryInterface $bookmarksRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
    }

    /**
     * Create a bookmark from URL.
     * 
     * @param String $url
     * @return Bookmark
     */
    public function create($url)
    {
        $domain = $this->extractDomain($url);
        return $this->bookmarksRepository->create(["url" => $url, "domain" => $domain]);
    }

}
