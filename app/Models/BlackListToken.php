<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackListToken extends Model
{
    protected $table = 'black_list_tokens';

    protected $fillable = [
        'user_id',
        'content'
    ];
}
