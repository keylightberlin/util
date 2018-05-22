<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class PasswordGenerator
{
    const DEFAULT_PASSWORD = '$2y$12$zAHMDp8Fh/kltqxmO45GIeCObOHwPyXHb.t41Mr12LMpvGEf/pXdq';

    /**
     * @return string
     */
    public static function getPassword(): string
    {
        return self::DEFAULT_PASSWORD;
    }
}
