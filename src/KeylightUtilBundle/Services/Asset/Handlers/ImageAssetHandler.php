<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetFactoryInterface;
use KeylightUtilBundle\Services\Asset\Providers\AssetStorageInterface;

class ImageAssetHandler implements AssetHandlerInterface
{
    /**
     * @var array
     */
    private $requiredImages;
    /**
     * @var AssetStorageInterface
     */
    private $assetStorage;
    /**
     * @var AssetFactoryInterface
     */
    private $assetFactory;

    /**
     * @param AssetStorageInterface $assetStorage
     * @param AssetFactoryInterface $assetFactory
     * @param array $requiredImages
     */
    public function __construct(
        AssetStorageInterface $assetStorage,
        AssetFactoryInterface $assetFactory,
        array $requiredImages
    ) {
        $this->requiredImages = $requiredImages;
        $this->assetStorage = $assetStorage;
        $this->assetFactory = $assetFactory;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function handleSave(Asset $asset)
    {
        $newImage = new \Imagick($asset->getFile()->getRealPath());
        $asset->setHeight($newImage->getImageHeight());
        $asset->setWidth($newImage->getImageWidth());

        /** @var array $requiredImage */
        foreach ($this->requiredImages as $requiredImage) {
            $newImage = new \Imagick($asset->getFile()->getRealPath());
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

            /**
             * This unfortunately kills the orientation. Leave EXIF-Info for now.
             *
             * $newImage->stripImage();
             * $newImage->setImageOrientation($orientation);
             */
            $childAsset = $this->assetFactory->getInstance();
            $childAsset->setStorageType($asset->getStorageType());
            $childAsset->setType($asset->getType());
            $childAsset->setFilename($newFilename);
            $childAsset->setProcessedType($requiredImage['name']);
            $childAsset->setHeight($newImage->getImageHeight());
            $childAsset->setWidth($newImage->getImageWidth());
            $asset->addChildAsset($childAsset);

            $this->assetStorage->saveAsset($childAsset);
        }
    }

    /**
     * @param $asset
     */
    public function handleRemove(Asset $asset)
    {
        // Get handled by generic handler already.
    }

    /**
     * @param Asset $asset
     * @return boolean
     */
    public function supportsAsset(Asset $asset)
    {
        return $asset->isImage();
    }
}