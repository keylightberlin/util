<?php
namespace KeylightUtilBundle\Services\Asset\AWS;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\Interfaces\AssetInterface;
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
     * @param AssetInterface $asset
     * @return string
     */
    public function getFileForAsset(AssetInterface $asset)
    {
        return file_get_contents($this->getUrlForAsset($asset));
    }

    /**
     * @param AssetInterface $asset
     * @return string
     */
    public function getUrlForAsset(AssetInterface $asset)
    {
        return $this->cloudfrontEndpoint . "/" . $asset->getRelativeUrl();
    }
}
