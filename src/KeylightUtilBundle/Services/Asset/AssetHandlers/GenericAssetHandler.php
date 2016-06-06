<?php
namespace KeylightUtilBundle\Services\Asset\AssetHandlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\SubAsset;
use KeylightUtilBundle\Services\Asset\AssetStorageInterface;
use KeylightUtilBundle\Services\Asset\AWS\S3Uploader;
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
        /** @var SubAsset $subAsset */
        foreach ($asset->getSubAssets() as $subAsset) {
            $this->entityManager->remove($subAsset, false);
        }
        $this->entityManager->flush();

        $asset->setOriginalFileName($asset->getUploadedFile()->getClientOriginalName());
        $ext = $asset->getUploadedFile()->guessExtension();
        $asset->setFileType($ext);
        $key = substr(sha1(uniqid()), 0, 15);
        $newFilename = $key . "." . $ext;
        $asset->setFilename($newFilename);

        $this->assetStorage->uploadAsset($asset);
    }

    /**
     * @param $asset
     */
    public function handleRemove($asset)
    {
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
