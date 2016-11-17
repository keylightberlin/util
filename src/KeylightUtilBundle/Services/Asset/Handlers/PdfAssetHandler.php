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
        $this->generatePngForPdf($asset, 300);
        $this->generateHtmlForPdf($asset);
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

    /**
     * @param Asset $asset
     * @param int $resolution
     */
    private function generatePngForPdf(Asset $asset, $resolution = 300)
    {
        $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME) . '.png';

        $documentImage = new \Imagick();
        $documentImage->setResolution($resolution, $resolution);
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
     * @param Asset $asset
     * @throws \Exception
     */
    private function generateHtmlForPdf(Asset $asset)
    {
        if (`which pdf2htmlEX`) {
            $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME) . '.html';

            $tempHtmlFile = tempnam(sys_get_temp_dir(), 'pdf2html');
            exec("pdf2htmlEX --dest-dir " . dirname($tempHtmlFile) . ' ' . $asset->getUploadedFile()->getRealPath() . ' ' . basename($tempHtmlFile));

            $handle = fopen($tempHtmlFile, "r");
            $htmlFileContent = fread($handle, filesize($tempHtmlFile));
            fclose($handle);
            unlink($tempHtmlFile);

            $childAsset = $this->assetFactory->getInstance();
            $childAsset->setStorageType($asset->getStorageType());
            $childAsset->setType($asset->getType());
            $childAsset->setFilename($newFilename);
            $childAsset->setFileContents($htmlFileContent);

            $asset->addChildAsset($childAsset);
            $this->assetStorage->saveAsset($childAsset);
        } else {
            throw new \Exception('pdf2htmlEX is not install');
        }
    }
}
