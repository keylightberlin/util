<?php
namespace KeylightUtilBundle\Model\Asset;

class ImageSizes
{
    const THUMBNAIL = 'thumbnail';
    const SMALL = 'small';
    const MIDDLE = 'middle';
    const LARGE = 'large';
    const ORIGINAL = 'original';

    static $DIMENSIONS = [
        self::THUMBNAIL => [
            'height' => 100
        ],
        self::SMALL => [
            'height' => 400
        ],
        self::MIDDLE => [
            'height' => 800
        ],
        self::LARGE => [
            'height' => 1024
        ]
    ];
}
