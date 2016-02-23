<?php
namespace KeylightUtilBundle\Services\Twig;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetProviderInterface;
use KeylightUtilBundle\Services\String\StringFormatter;

class KeylightTwigExtension extends \Twig_Extension
{
    /**
     * @var StringFormatter
     */
    private $stringFormatter;
    /**
     * @var AssetProviderInterface
     */
    private $assetProvider;

    /**
     * @param StringFormatter $stringFormatter
     * @param AssetProviderInterface $assetProviderInterface
     */
    public function __construct(StringFormatter $stringFormatter, AssetProviderInterface $assetProviderInterface)
    {
        $this->stringFormatter = $stringFormatter;
        $this->assetProvider = $assetProviderInterface;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('money', [$this, 'formatMoney']),
            new \Twig_SimpleFilter('defaultDate', [$this, 'formatDate']),
            new \Twig_SimpleFilter('shortDate', [$this, 'formatShortDate']),
            new \Twig_SimpleFilter('fullDate', [$this, 'formatFullDate']),
            new \Twig_SimpleFilter('cloudfrontUrl', [$this, 'cloudfrontUrl']),
            new \Twig_SimpleFilter('publicUrl', [$this, 'publicUrl']),
            new \Twig_SimpleFilter('dateWeekday', [$this, 'dateWeekday']),
            new \Twig_SimpleFilter('alertIfNotTranslated', [$this, 'alertIfNotTranslated'], array('is_safe' => array('html'))),
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
     * @param \DateTime $date
     * @return string
     */
    public function formatFullDate(\DateTime $date = null)
    {
        return $this->stringFormatter->formatDateTime($date);
    }

    /**
     * @deprecated Use publicUrl instead.
     *
     * @param Asset $asset
     * @return string
     */
    public function cloudfrontUrl(Asset $asset)
    {
        return $this->assetProvider->getUrlForAsset($asset);
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function publicUrl(Asset $asset)
    {
        return $this->assetProvider->getUrlForAsset($asset);
    }

    /**
     * @param string $value
     * @return string
     */
    public function alertIfNotTranslated($value)
    {
        return false === empty($value) ? $value : "<span class='needs-translation'>[ needs translation ]</span>";
    }

    /**
     * @param \DateTime|null $date
     * @return string
     */
    public function dateWeekday(\DateTime $date)
    {
        return $this->stringFormatter->getFullWeekday($date);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "keylight_util_twig_extension";
    }
}
