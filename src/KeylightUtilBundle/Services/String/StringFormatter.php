<?php
namespace KeylightUtilBundle\Services\String;

class StringFormatter
{
    /**
     * @param float $value
     * @return string
     */
    public function formatMoney($value)
    {
        return number_format($value, 2, ',', '.') . " €";
    }

    /**
     * @param \DateTime|null $dateTime
     * @return string
     */
    public function formatDate(\DateTime $dateTime = null)
    {
        return $dateTime->format('d.m.Y');
    }

    /**
     * @param \DateTime|null $dateTime
     * @return string
     */
    public function formatShortDate(\DateTime $dateTime = null)
    {
        return $dateTime->format('d.m.');
    }
}
