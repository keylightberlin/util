<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetHandlers\AssetHandlerInterface;

class AssetManager implements AssetManagerInterface
{
    /**
     * @var \SplPriorityQueue
     */
    private $assetHandlers;

    public function __construct()
    {
        $this->assetHandlers = new \SplPriorityQueue();
    }

    /**
     * @param Asset $asset
     */
    public function saveAsset(Asset $asset)
    {
        /** @var AssetHandlerInterface $assetHandler */
        foreach (clone $this->assetHandlers as $assetHandler) {
            if ($assetHandler->supportsAsset($asset)) {
                $assetHandler->handleSave($asset);
            }
        }
    }

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        /** @var AssetHandlerInterface $assetHandler */
        foreach (clone $this->assetHandlers as $assetHandler) {
            if ($assetHandler->supportsAsset($asset)) {
                $assetHandler->handleRemove($asset);
            }
        }
    }

    /**
     * @param AssetHandlerInterface $assetHandler
     * @param int $priority
     */
    public function addAssetHandler(AssetHandlerInterface $assetHandler, $priority)
    {
        $this->assetHandlers->insert($assetHandler, $priority);
    }
}
