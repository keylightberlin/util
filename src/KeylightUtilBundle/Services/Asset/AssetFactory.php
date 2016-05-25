<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Model\Asset\AssetStorageTypes;

class AssetFactory implements AssetFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getInstance()
    {
        $asset = new Asset();
        $asset->setProcessedType("original");
        $asset->setStorageType(AssetStorageTypes::PUBLIC_STORAGE);

        return $asset;
    }
}
