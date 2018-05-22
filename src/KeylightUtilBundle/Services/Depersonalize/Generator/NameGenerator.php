<?php
namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class NameGenerator
{
    private static $maleNames = [
        'David',
        'John',
        'Robert',
        'Steven',
        'William',
        'Mark',
        'Thomas',
        'Michael',
        'Richard',
        'Kevin',
        'Donald',
        'Andrew',
        'Andreas',
        'Eugene',
        'William',
        'Alexandr',
        'Markus',
        'Gregor',
        'Daniel',
    ];

    private static $femaleNames = [
        'Patricia',
        'Taylor',
        'Susan',
        'Lisa',
        'Linda',
        'Sandra',
        'Carol',
        'Debra',
        'Teresa',
        'Rebecca',
        'Diana',
        'Veronika',
        'Helen',
        'Alexandra',
        'Stephanie',
        'Elona',
        'Brigitte',
        'Mila',
        'Sophia',
        'Kirstie',
        'Nicole',
    ];

    private static $lastNames = [
        'Johnson',
        'Anderson',
        'Reed',
        'Erickson',
        'Frank',
        'Lucas',
        'Jenkins',
        'Watson',
        'Morgan',
        'Kim',
        'Schmidt',
        'Muller',
        'Adler',
        'Gallagher',
    ];

    /**
     * @return string
     */
    public static function getName(): string
    {
        $name = rand(0,1)?self::getFemaleName():self::getMaleName();

        return $name;
    }

    /**
     * @return string
     */
    public static function getMaleName(): string
    {
        return self::$maleNames[array_rand(self::$maleNames)];
    }

    /**
     * @return string
     */
    public static function getFemaleName(): string
    {
        return self::$femaleNames[array_rand(self::$femaleNames)];
    }

    /**
     * @return string
     */
    public static function getLastName(): string
    {
        return self::$lastNames[array_rand(self::$lastNames)];
    }

    /**
     * @return string
     */
    public static function getFullName():string
    {
        return self::getName() . ' ' . self::getLastName();
    }

}
