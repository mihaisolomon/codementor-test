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
        'content',
        'impact',
        'ease',
        'confidence',
        'average_score'
    ];

    protected $hidden = ['updated_at', 'user_id'];
}
