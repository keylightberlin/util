<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\Interfaces\AssetInterface;

interface AssetProviderInterface
{
    /**
     * @param AssetInterface $assetInterface
     * @return string
     */
    public function getFileForAsset(AssetInterface $assetInterface);

    /**
     * @param AssetInterface $assetInterface
     * @return string
     */
    public function getUrlForAsset(AssetInterface $assetInterface);
}
