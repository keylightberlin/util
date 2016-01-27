<?php
namespace KeylightUtilBundle\Model\Asset;

class AssetTypes
{
    const IMAGE = 'image';

    const VIDEO = 'video';

    const PDF = 'pdf';

    const AUDIO = 'audio';

    /**
     * @return array
     */
    static function getAsArray()
    {
        return [
            static::IMAGE,
            static::VIDEO,
            static::PDF,
            static::AUDIO,
        ];
    }
}
