<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;


use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetFactoryInterface;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;

class PdfAssetHandler implements AssetHandlerInterface
{
    /**
     * @var AssetStorageInterface
     */
    private $assetStorage;

    /**
     * @var AssetFactoryInterface
     */
    private $assetFactory;



    public function __construct(
        AssetStorageInterface $assetStorage,
        AssetFactoryInterface $assetFactory
    ) {
        $this->assetStorage = $assetStorage;
        $this->assetFactory = $assetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function handleSave(Asset $asset)
    {
        $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME) . '.png';

        $documentImage = new \Imagick();
        $documentImage->setResolution(300, 300);
        $documentImage->readImage($asset->getUploadedFile()->getRealPath());
        $documentImage->resetIterator();

        $documentImage = $documentImage->appendImages(true);
        $documentImage = $documentImage->flattenImages();
        $documentImage->setImageFormat('png');

        $childAsset = $this->assetFactory->getInstance();
        $childAsset->setStorageType($asset->getStorageType());
        $childAsset->setType($asset->getType());
        $childAsset->setFilename($newFilename);

        $childAsset->setHeight($documentImage->getImageHeight());
        $childAsset->setWidth($documentImage->getImageWidth());
        $childAsset->setFileContents($documentImage);

        $asset->addChildAsset($childAsset);
        $this->assetStorage->saveAsset($childAsset);
    }

    /**
     * {@inheritdoc}
     */
    public function handleRemove(Asset $asset)
    {
        // Get handled by generic handler already.
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    public function supportsAsset(Asset $asset)
    {
        return $asset->isPdf();
    }
}
