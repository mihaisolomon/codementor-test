<?php


namespace App\Services\BlackListTokens;

use App\Repositories\BlackListTokens\BlackListTokensRepositoryInterface;
use App\Repository\BaseRepositoryInterface;
use App\Services\BaseService;

class BlackListTokensService extends BaseService implements BlackListTokensServiceInterface
{
    public function __construct(BlackListTokensRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
