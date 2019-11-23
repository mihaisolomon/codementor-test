<?php


namespace App\Services\Users;

use App\Repositories\Users\UsersRepositoryInterface;
use App\Repository\BaseRepositoryInterface;
use App\Services\BaseService;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(UsersRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
