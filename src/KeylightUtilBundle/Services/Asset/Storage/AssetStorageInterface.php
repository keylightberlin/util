<?php
namespace KeylightUtilBundle\Services\Asset\Providers;

use KeylightUtilBundle\Entity\Asset;

interface AssetStorageInterface
{
    /**
     * @param Asset $asset
     * @return mixed
     */
    public function saveAsset(Asset $asset);

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset);
}
