<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 13:51
 */

namespace App\Repositories\Ideas;

use App\Repository\BaseRepositoryInterface;
use App\User;

interface IdeasRepositoryInterface extends BaseRepositoryInterface
{
    public function getPaginated(User $user);
}
