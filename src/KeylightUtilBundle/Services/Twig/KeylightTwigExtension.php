<?php
namespace KeylightUtilBundle\Services\Twig;

use KeylightUtilBundle\Services\String\StringFormatter;

class KeylightTwigExtension extends \Twig_Extension
{
    /**
     * @var StringFormatter
     */
    private $stringFormatter;

    /**
     * @param StringFormatter $stringFormatter
     */
    public function __construct(StringFormatter $stringFormatter)
    {
        $this->stringFormatter = $stringFormatter;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('money', [$this, 'formatMoney']),
            new \Twig_SimpleFilter('defaultDate', [$this, 'formatDate']),
            new \Twig_SimpleFilter('shortDate', [$this, 'formatShortDate'])
        ];
    }

    /**
     * @param float $value
     * @return string
     */
    public function formatMoney($value)
    {
        return $this->stringFormatter->formatMoney($value);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatDate(\DateTime$date)
    {
        return $this->stringFormatter->formatDate($date);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatShortDate(\DateTime$date)
    {
        return $this->stringFormatter->formatShortDate($date);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "getlocal_twig_extension";
    }
}
