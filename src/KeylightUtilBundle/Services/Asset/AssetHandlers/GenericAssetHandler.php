<?php
namespace KeylightUtilBundle\Services\Asset\AssetHandlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetStorageInterface;
use KeylightUtilBundle\Services\Asset\AWS\S3Uploader;

class GenericAssetHandler implements AssetHandlerInterface
{
    /**
     * @var AssetStorageInterface
     */
    private $assetStorage;

    /**
     * @param AssetStorageInterface $assetStorage
     */
    public function __construct(AssetStorageInterface $assetStorage)
    {
        $this->assetStorage = $assetStorage;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset)
    {
        $asset->setOriginalFileName($asset->getUploadedFile()->getClientOriginalName());
        $ext = $asset->getUploadedFile()->guessExtension();
        $asset->setFileType($ext);
        $key = sha1(uniqid());
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
