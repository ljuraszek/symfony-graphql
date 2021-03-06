<?php declare(strict_types = 1);

namespace App\Repository\Query;

use App\Repository\TagRepository;

abstract class TagQuery
{
    /** @var TagRepository */
    protected $repository;
    
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }
}
