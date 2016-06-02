<?php
namespace KeylightUtilBundle\Services\Asset\Providers;

use KeylightUtilBundle\Entity\Asset;

interface AssetProviderInterface
{
    /**
     * @param Asset $asset
     * @return string
     */
    public function getFileForAsset(Asset $asset);

    /**
     * @param Asset $asset
     * @return string
     */
    public function getUrlForAsset(Asset $asset);
}
