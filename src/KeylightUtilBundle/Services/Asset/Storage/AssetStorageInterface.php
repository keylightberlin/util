<?php
namespace KeylightUtilBundle\Services\Asset\Storage;

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
