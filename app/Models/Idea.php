<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 13:52
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $table = 'ideas';

    protected $fillable = [
        'user_id',
        'name',
        'impact',
        'ease',
        'confidence',
        'average'
    ];

    protected $hidden = ['updated_at', 'user_id'];
}
