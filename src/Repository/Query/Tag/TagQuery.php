<?php declare(strict_types = 1);

namespace App\Repository\Query\Tag;

use App\Repository\TagRepository;

class TagQuery
{
    /** @var TagRepository */
    protected $repository;
    
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }
}
