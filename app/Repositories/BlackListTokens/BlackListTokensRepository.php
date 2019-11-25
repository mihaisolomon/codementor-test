<?php


namespace App\Repositories\BlackListTokens;

use App\Models\BlackListToken;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class BlackListTokensRepository extends BaseRepository implements BlackListTokensRepositoryInterface
{
    public function __construct(BlackListToken $model)
    {
        parent::__construct($model);
    }
}
