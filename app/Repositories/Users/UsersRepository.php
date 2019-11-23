<?php


namespace App\Repositories\Users;

use App\Repository\BaseRepository;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
