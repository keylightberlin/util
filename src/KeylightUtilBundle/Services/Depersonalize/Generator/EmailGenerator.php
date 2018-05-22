<?php

namespace KeylightUtilBundle\Services\Depersonalize\Generator;

class EmailGenerator
{
    private static $domains = [
        'example.com',
        'test.com',
        'dummy.org',
    ];

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string|null $domain
     * @param null $uniqueId
     * @return string
     */
    public static function getEmail(string $firstName, string $lastName, string $domain = null, $uniqueId = null)
    {
        $email = preg_replace('/\s+/', '', $firstName) . '.' . preg_replace('/\s+/', '', $lastName);

        if (null !== $uniqueId) {
            $email .= '.' . $uniqueId;
        }

        $email .= '@';

        if (null === $domain) {
            $domain = self::getRandomDomain();
        } else {
            $domain = strtolower($domain);
        }
        $email .= $domain;

        return strtolower($email);
    }

    /**
     * @return string
     */
    private static function getRandomDomain():string
    {
        return self::$domains[array_rand(self::$domains)];
    }
}
