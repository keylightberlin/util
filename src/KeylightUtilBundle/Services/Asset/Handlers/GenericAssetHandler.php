<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;
use KeylightUtilBundle\Services\EntityManager\EntityManager;
use League\Flysystem\Filesystem;

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
        foreach ($asset->getChildAssets() as $subAsset) {
            $this->entityManager->remove($subAsset, false);
            $this->assetStorage->removeAsset($subAsset);
        }
        $this->entityManager->flush();
        /** If it's the same field, skip initializing and uploading it. */
        $asset->setPath("");
        $asset->setOriginalFileName($asset->getUploadedFile()->getClientOriginalName());
        $ext = $asset->getUploadedFile()->guessExtension();
        $asset->setProcessedType("original");
        $asset->setFileType($ext);
        $key = substr(sha1(uniqid()), 0, 15);
        $newFilename = $key . "." . $ext;
        $asset->setFilename($newFilename);
        $this->assetStorage->saveAsset($asset);
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
