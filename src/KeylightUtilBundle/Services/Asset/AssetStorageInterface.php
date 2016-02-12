<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;

interface AssetStorageInterface
{
    /**
     * @param Asset $asset
     * @return mixed
     */
    public function uploadAsset(Asset $asset);

    /**
     * @param string $fileName
     * @param string $fileContents
     * @return mixed
     */
    public function uploadFile($fileName, $fileContents);

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset);
}
