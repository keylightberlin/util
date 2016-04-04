<?php
namespace KeylightUtilBundle\Services\String;

final class RandomStringUtil
{
    const PATTERN_SMALL_LETTER = "l";
    const PATTERN_CAPITAL_LETTER = "L";
    const PATTERN_ANY_LETTER = "w";
    const PATTERN_NUMBER = "n";
    const PATTERN_ANY_CHAR = "c";
    const PATTERN_ANY_CHAR_OR_SYMBOL = "s";

    const NUMBERS = "0123456789";
    const SMALL_LETTERS = "abcdefghijklmnopqrstuvwxyz";
    const CAPITAL_LETTERS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const SYMBOLS = "#+&%$*";

    /**
     * Returns a random string of charcters and numbers.
     *
     * @param int $length
     * @return string
     */
    public function getRandomString($length)
    {
        return $this->getRandomStringForPattern(str_repeat(static::PATTERN_ANY_CHAR, $length));
    }

    /**
     * @param $pattern
     * @return string
     */
    public function getRandomStringForPattern($pattern)
    {
        $patternArray = str_split($pattern);
        $randomString = "";

        /** @var string $patternChar */
        foreach ($patternArray as $patternChar) {
            $randomString .= $this->getSymbolForPatternChar($patternChar);
        }

        return $randomString;
    }

    /**
     * @param string $patternChar
     * @return string
     */
    private function getSymbolForPatternChar($patternChar)
    {
        $resolvedSymbol = $patternChar;

        switch ($patternChar) {
            case static::PATTERN_SMALL_LETTER:
                $resolvedSymbol = $this->getRandomSmallLetter();
                break;
            case static::PATTERN_CAPITAL_LETTER:
                $resolvedSymbol = $this->getRandomCapitalLetter();
                break;
            case static::NUMBERS:
                $resolvedSymbol = $this->getRandomNumber();
                break;
            case static::PATTERN_ANY_CHAR:
                $resolvedSymbol = $this->getRandomChar();
                break;
            case static::PATTERN_ANY_LETTER:
                $resolvedSymbol = $this->getRandomLetter();
                break;
            case static::PATTERN_ANY_CHAR_OR_SYMBOL:
                $resolvedSymbol = $this->getRandomCharOrSymbol();
                break;
        }
        
        return $resolvedSymbol;
    }

    /**
     * @return string
     */
    public function getRandomSmallLetter()
    {
        return $this->getRandomCharFromSet(static::SMALL_LETTERS);
    }

    /**
     * @return string
     */
    public function getRandomCapitalLetter()
    {
        return $this->getRandomCharFromSet(static::CAPITAL_LETTERS);
    }

    /**
     * @return string
     */
    public function getRandomLetter()
    {
        return $this->getRandomCharFromSet(static::SMALL_LETTERS . static::CAPITAL_LETTERS);
    }

    /**
     * @return string
     */
    public function getRandomNumber()
    {
        return $this->getRandomCharFromSet(static::NUMBERS);
    }

    /**
     * @return string
     */
    public function getRandomChar()
    {
        return $this->getRandomCharFromSet(static::SMALL_LETTERS . static::CAPITAL_LETTERS . static::NUMBERS);
    }

    /**
     * @return string
     */
    public function getRandomCharOrSymbol()
    {
        return $this->getRandomCharFromSet(
            static::SMALL_LETTERS
            . static::CAPITAL_LETTERS
            . static::NUMBERS
            . static::SYMBOLS
        );
    }

    /**
     * @param string $set
     * @return string
     */
    private function getRandomCharFromSet($set)
    {
        return substr($set, mt_rand(0, strlen($set)), 1);
    }
}

