<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Handlers\AssetHandlerInterface;

interface AssetManagerInterface
{
    /**
     * @param Asset $asset
     */
    public function saveAsset(Asset $asset);

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset);

    /**
     * @param AssetHandlerInterface $assetHandler
     * @param int $priority
     */
    public function addAssetHandler(AssetHandlerInterface $assetHandler, $priority);
}
