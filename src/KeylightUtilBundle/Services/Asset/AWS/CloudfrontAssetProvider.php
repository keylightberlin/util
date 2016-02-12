<?php
namespace KeylightUtilBundle\Services\Asset\AWS;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetProviderInterface;

class CloudfrontAssetProvider implements AssetProviderInterface
{
    /**
     * @var string
     */
    private $cloudfrontEndpoint;

    /**
     * @param string $cloudfrontEndpoint
     */
    public function __construct($cloudfrontEndpoint)
    {
        $this->cloudfrontEndpoint = $cloudfrontEndpoint;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function getFileForAsset(Asset $asset)
    {
        return file_get_contents($this->getUrlForAsset($asset));
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function getUrlForAsset(Asset $asset)
    {
        return $this->cloudfrontEndpoint . "/" . $asset->getRelativeUrl();
    }
}
