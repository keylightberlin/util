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
        $newImage = new \Imagick($asset->getUploadedFile()->getRealPath());
        $asset->setHeight($newImage->getImageHeight());
        $asset->setWidth($newImage->getImageWidth());

        /** @var array $requiredImage */
        foreach ($this->requiredImages as $requiredImage) {
            $newImage = new \Imagick($asset->getUploadedFile()->getRealPath());
            $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME)
                . '-'
                . $requiredImage['name']
                . '.' .
                pathinfo($asset->getFilename(), PATHINFO_EXTENSION);

            $imageWidth = $newImage->getImageWidth();
            $imageHeight = $newImage->getImageHeight();
            $isLandscapeFormat = $imageWidth > $imageHeight;
            $orientation = $newImage->getImageOrientation();

            $newImage->setCompression(\Imagick::COMPRESSION_JPEG);
            $newImage->setImageCompressionQuality($requiredImage['quality']);

            if ($isLandscapeFormat) {
                $desiredWidth = $requiredImage['long'];
                $newImage->resizeImage($desiredWidth, 0, \Imagick::FILTER_LANCZOS, 1);

                if (isset($requiredImage['short']) && boolval($requiredImage['crop']) == true) {
                    $newImage->cropImage($desiredWidth, $requiredImage['short'], 0, 0);
                } else {
                    $newImage->resizeImage(0, $requiredImage['short'], \Imagick::FILTER_LANCZOS, 1);
                }
            } else {
                $desiredHeight = $requiredImage['long'];
                $newImage->resizeImage(0, $desiredHeight, \Imagick::FILTER_LANCZOS, 1);

                if (isset($requiredImage['short']) && boolval($requiredImage['crop']) == true) {
                    $newImage->cropImage($requiredImage['short'], $desiredHeight, 0, 0);
                } else {
                    $newImage->resizeImage($requiredImage['short'], 0, \Imagick::FILTER_LANCZOS, 1);
                }
            }

            $newImage->stripImage();
            $newImage->setImageOrientation($orientation);

            $this->s3Uploader->uploadFile($newFilename, $newImage);

            $subAsset = new SubAsset();
            $subAsset->setFilename($newFilename);
            $subAsset->setType($requiredImage['name']);
            $subAsset->setHeight($newImage->getImageHeight());
            $subAsset->setWidth($newImage->getImageWidth());
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
