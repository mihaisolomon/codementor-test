<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 14:11
 */

namespace App\Services;


class Gravatar
{
    public static function avatar($email)
    {
        return self::get_gravatar($email);
    }

    private static function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s={$s}&d={$d}&r={$r}";

        return $url;
    }
}
