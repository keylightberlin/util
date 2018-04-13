<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class TokenGenerator
{
    /**
     * @param null $length
     * @return bool|string
     */
    public static function getToken($length = null)
    {
        return substr(md5(rand()), 0, $length);
    }
}
