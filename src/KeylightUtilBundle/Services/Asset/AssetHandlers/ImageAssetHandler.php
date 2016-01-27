<?php
namespace KeylightUtilBundle\Services\Asset\AssetHandlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\SubAsset;
use KeylightUtilBundle\Model\Asset\AssetTypes;
use KeylightUtilBundle\Services\Asset\AWS\S3Uploader;

class ImageAssetHandler implements AssetHandlerInterface
{
    /**
     * @var array
     */
    private $requiredImages;
    /**
     * @var S3Uploader
     */
    private $s3Uploader;

    /**
     * @param S3Uploader $s3Uploader
     * @param array $requiredImages
     */
    public function __construct(S3Uploader $s3Uploader, array $requiredImages)
    {
        $this->requiredImages = $requiredImages;
        $this->s3Uploader = $s3Uploader;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset)
    {
        /** @var array $requiredImage */
        foreach ($this->requiredImages as $requiredImage) {
            $newImage = new \Imagick($asset->getUploadedFile()->getRealPath());
            $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME)
                . '-'
                . $requiredImage['name']
                . '.' .
                pathinfo($asset->getFilename(), PATHINFO_EXTENSION);

            $desiredWidth = isset($requiredImage['width']) ? $requiredImage['width'] : 0;
            $desiredHeight = isset($requiredImage['height']) ? $requiredImage['height'] : 0;
            $newImage->resizeImage(0, $desiredHeight, \Imagick::FILTER_LANCZOS, 1);
            if ($desiredWidth > 0 && $desiredHeight > 0) {
                $newImage->cropImage($desiredWidth, $desiredHeight, 0, 0);
            }

            $this->s3Uploader->uploadFile($newFilename, $newImage);

            $subAsset = new SubAsset();
            $subAsset->setFilename($newFilename);
            $subAsset->setType($requiredImage['name']);
            $asset->addSubAsset($subAsset);
        }
    }

    /**
     * @param $asset
     */
    public function handleRemove($asset)
    {
        // TODO: Implement handleRemove() method.
    }

    /**
     * @param Asset $asset
     * @return boolean
     */
    public function supportsAsset(Asset $asset)
    {
        return AssetTypes::IMAGE === $asset->getType();
    }
}
