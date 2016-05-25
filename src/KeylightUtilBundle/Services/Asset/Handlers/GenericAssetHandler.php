<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Providers\AssetStorageInterface;
use KeylightUtilBundle\Services\EntityManager\EntityManager;

class GenericAssetHandler implements AssetHandlerInterface
{
    /**
     * @var AssetStorageInterface
     */
    private $assetStorage;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param AssetStorageInterface $assetStorage
     * @param EntityManager $entityManager
     */
    public function __construct(AssetStorageInterface $assetStorage, EntityManager $entityManager)
    {
        $this->assetStorage = $assetStorage;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset)
    {
        /** @var Asset $asset */
        foreach ($asset->getChildAssets() as $asset) {
            $this->entityManager->remove($asset, false);
            $this->assetStorage->removeAsset($asset);
        }
        $this->entityManager->flush();

        /** If it's the same field, skip initializing and uploading it. */
        if ($asset->getOriginalFileName() !== $asset->getFile()->getClientOriginalName()) {
            $asset->setOriginalFileName($asset->getFile()->getClientOriginalName());
            $ext = $asset->getFile()->guessExtension();
            $asset->setFileType($ext);
            $key = substr(sha1(uniqid()), 0, 15);
            $newFilename = $key . "." . $ext;
            $asset->setFilename($newFilename);

            $this->assetStorage->saveAsset($asset);
        }
    }

    /**
     * @param Asset $asset
     */
    public function handleRemove(Asset $asset)
    {
        $this->entityManager->remove($asset);
        $this->assetStorage->removeAsset($asset);
    }

    /**
     * @param Asset $asset
     * @return boolean
     */
    public function supportsAsset(Asset $asset)
    {
        return true;
    }
}
