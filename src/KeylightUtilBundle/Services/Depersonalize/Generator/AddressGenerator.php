<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class AddressGenerator
{
    private static $streetsList = [
        'Bismarckstr.',
        'Frankfurter Allee',
        'Kurfürstendamm',
        'Schönhauser Allee',
        'Flughafenstrasse',
        'Mohrenstrasse',
        'Motzstr.',
        'Knesebeckstrasse',
        'Scharnweberstrasse',
        'Bleibtreustrasse',
        'Fasanenstrasse',
        'Prager Str',
        'Gotthardstrasse',
        'Meinekestraße',
        'Pohlstrasse',
        'Lange Strasse',
        'Inge Beisheim Platz',
        'Kantstraße',
        'Wallstrasse',
        'An Der Urania',
        'Leipziger Straße',
        'Schaarsteinweg',
        'Los-Angeles-Platz',
        'Rankestraße',
        'Grolmanstraße',
    ];

    private static $cityList = [
        'Zurich',
    ];

    private static $countryList = [
        'Switzerland',
    ];

    /**
     * @return string
     */
    public static function getStreet(): string
    {
        return self::$streetsList[array_rand(self::$streetsList)];
    }

    /**
     * @return string
     */
    public static function getHouseNumber(): string
    {
        return rand(1, 40);
    }

    /**
     * @return string
     */
    public static function getAddress(): string
    {
        return self::getStreet() . ' ' . self::getHouseNumber();
    }

    /**
     * @return string
     */
    public static function getCity(): string
    {
        return self::$cityList[array_rand(self::$cityList)];

    }

    /**
     * @return string
     */
    public static function getCountry(): string
    {
        return self::$cityList[array_rand(self::$countryList)];
    }

    /**
     * @return string
     */
    public static function getZipCode(): string
    {
        return rand(1000, 1099);
    }
}
