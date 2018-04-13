<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class PhoneNumberGenerator
{
    const DIGITS = 8;

    const COUNTRY_CODE_DE = 'DE';

    const COUNTRY_CODE_AT = 'AT';

    const COUNTRY_CODE_CH = 'CH';

    const COUNTRY_PHONE_CODE_DE = '+49';

    const COUNTRY_PHONE_CODE_AT = '+49';

    const COUNTRY_PHONE_CODE_CH = '+41';

    private static $countryCodes = [
        self::COUNTRY_CODE_AT => self::COUNTRY_PHONE_CODE_AT,
        self::COUNTRY_CODE_DE => self::COUNTRY_PHONE_CODE_DE,
        self::COUNTRY_CODE_CH => self::COUNTRY_PHONE_CODE_CH,
    ];

    /**
     * @param string|null $countryCode
     * @return string
     */
    public static function getPhoneNumber(string $countryCode = null): string
    {
        $countryPhoneCode = self::validateCountryCode($countryCode)
            ? self::$countryCodes[$countryCode]
            : self::$countryCodes[array_rand(self::$countryCodes)];

        $min = pow(10, self::DIGITS);

        $phoneNumber = rand($min, $min * 10 - 1);

        return $countryPhoneCode . ' ' . $phoneNumber;
    }

    /**
     * @param string $countryCode
     * @return bool
     */
    static private function validateCountryCode(?string $countryCode): bool
    {
        return array_key_exists($countryCode, self::$countryCodes);
    }
}
