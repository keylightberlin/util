<?php
namespace KeylightUtilBundle\Services\String;

class StringFormatter
{
    /**
     * @param float $value
     * @param string $currency
     * @return string
     */
    public function formatMoney($value, $currency = " €")
    {
        return number_format($value, 2, ',', '.') . " " . $currency;
    }

    /**
     * @param \DateTime|null $dateTime
     * @return string
     */
    public function formatDate(\DateTime $dateTime = null)
    {
        return $dateTime ? $dateTime->format('d.m.Y') : '-';
    }

    /**
     * @param \DateTime|null $dateTime
     * @return string
     */
    public function formatShortDate(\DateTime $dateTime = null)
    {
        return $dateTime ? $dateTime->format('d.m.') : '-';
    }
}
