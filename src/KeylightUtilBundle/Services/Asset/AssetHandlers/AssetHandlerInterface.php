<?php
namespace KeylightUtilBundle\Services\Asset\AssetHandlers;

use KeylightUtilBundle\Entity\Asset;

interface AssetHandlerInterface
{
    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset);

    /**
     * @param $asset
     */
    public function handleRemove($asset);

    /**
     * @param Asset $asset
     * @return boolean
     */
    public function supportsAsset(Asset $asset);
}
