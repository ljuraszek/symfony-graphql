<?php declare(strict_types = 1);

namespace App\Repository\Query;

use App\Repository\PostRepository;

abstract class PostQuery
{
    /** @var PostRepository */
    protected $repository;
    
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }
}
