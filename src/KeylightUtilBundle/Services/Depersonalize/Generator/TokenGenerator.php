<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class TokenGenerator
{
    /**
     * @param int $length
     * @return bool|string
     */
    public static function getToken(int $length = null)
    {
        return substr(md5(rand()), 0, $length);
    }
}
