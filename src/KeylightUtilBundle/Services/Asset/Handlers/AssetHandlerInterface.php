<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;

use KeylightUtilBundle\Entity\Asset;

interface AssetHandlerInterface
{
    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset);

    /**
     * @param Asset $asset
     */
    public function handleRemove(Asset $asset);

    /**
     * @param Asset $asset
     * @return bool
     */
    public function supportsAsset(Asset $asset);
}
