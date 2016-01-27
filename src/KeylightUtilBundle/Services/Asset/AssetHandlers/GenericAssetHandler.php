<?php
namespace KeylightUtilBundle\Services\Asset\AssetHandlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AWS\S3Uploader;

class GenericAssetHandler implements AssetHandlerInterface
{
    /**
     * @var S3Uploader
     */
    private $s3Uploader;

    /**
     * @param S3Uploader $s3Uploader
     */
    public function __construct(S3Uploader $s3Uploader)
    {
        $this->s3Uploader = $s3Uploader;
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

        $this->s3Uploader->uploadAsset($asset);
    }

    /**
     * @param $asset
     */
    public function handleRemove($asset)
    {
        $this->s3Uploader->removeAsset($asset);
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
