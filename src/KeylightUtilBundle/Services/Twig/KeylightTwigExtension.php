<?php
namespace KeylightUtilBundle\Services\Twig;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\String\StringFormatter;

class KeylightTwigExtension extends \Twig_Extension
{
    /**
     * @var StringFormatter
     */
    private $stringFormatter;
    /**
     * @var string
     */
    private $cloudfrontEndpoint;

    /**
     * @param StringFormatter $stringFormatter
     * @param string $cloudfrontEndpoint
     */
    public function __construct(StringFormatter $stringFormatter, $cloudfrontEndpoint)
    {
        $this->stringFormatter = $stringFormatter;
        $this->cloudfrontEndpoint = $cloudfrontEndpoint;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('money', [$this, 'formatMoney']),
            new \Twig_SimpleFilter('defaultDate', [$this, 'formatDate']),
            new \Twig_SimpleFilter('shortDate', [$this, 'formatShortDate']),
            new \Twig_SimpleFilter('cloudfrontUrl', [$this, 'cloudfrontUrl']),
        ];
    }

    /**
     * @param float $value
     * @param null $currency
     * @return string
     */
    public function formatMoney($value, $currency = null)
    {
        return $this->stringFormatter->formatMoney($value, $currency);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatDate(\DateTime $date = null)
    {
        return $this->stringFormatter->formatDate($date);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatShortDate(\DateTime $date = null)
    {
        return $this->stringFormatter->formatShortDate($date);
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function cloudfrontUrl(Asset $asset)
    {
        return $this->cloudfrontEndpoint . "/" . $asset->getRelativeUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "getlocal_twig_extension";
    }
}
