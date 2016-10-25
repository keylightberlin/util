<?php
namespace KeylightUtilBundle\Util;

final class ArrayUtil
{
    /**
     * @param array $array
     * @param null $label
     * @return array
     */
    public static function getMappedArray(array $array, $label = null)
    {
        return array_map(
            function ($elem) use ($label) {
                return $label . $elem;
            },
            $array
        );
    }

    /**
     * @param array $array
     * @param null $label
     * @return array
     */
    public static function getMappedAndCombinedArray(array $array, $label = null)
    {
        return array_combine(
            self::getMappedArray($array, $label),
            $array
        );
    }
}
