<?php
namespace KeylightUtilBundle\Services\Asset\Handlers;


use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\AssetFactoryInterface;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;

class PdfAssetHandler implements AssetHandlerInterface
{
    const PNG = 'png';
    const JPEG = 'jpeg';
    const HTML = 'html';

    /**
     * @var AssetStorageInterface
     */
    private $assetStorage;

    /**
     * @var AssetFactoryInterface
     */
    private $assetFactory;

    /**
     * @var array
     */
    private $requiredFormats;

    public function __construct(
        AssetStorageInterface $assetStorage,
        AssetFactoryInterface $assetFactory,
        array $requiredFormats
    ) {
        $this->assetStorage = $assetStorage;
        $this->assetFactory = $assetFactory;
        $this->requiredFormats = $requiredFormats;
    }

    /**
     * {@inheritdoc}
     */
    public function handleSave(Asset $asset)
    {
        /** @var array $requiredFormats */
        foreach ($this->requiredFormats as $requiredFormat) {
            switch ($requiredFormat['type']){
                case self::PNG:
                    $this->generateForFormat($asset, $requiredFormat['resolution'], 'png');
                    break;
                case self::JPEG:
                    $this->generateForFormat($asset, $requiredFormat['resolution'], 'jpg');
                    break;
                case self::HTML:
                    $this->generateHtml($asset);
                    break;
            }
        }
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
        return $asset->isPdf() && false === boolval($asset->isSkipProcessing());
    }

    /**
     * @param Asset $asset
     * @param int $resolution
     */
    private function generateForFormat(Asset $asset, $resolution = 300, $format = 'png')
    {
        $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME) . '.' . $format;

        $documentImage = new \Imagick();
        $documentImage->setColorspace(\Imagick::COLORSPACE_RGB);
        $documentImage->setResolution($resolution, $resolution);
        $documentImage->readImage($asset->getUploadedFile()->getRealPath());
        $documentImage->resetIterator();
        $documentImage = $documentImage->appendImages(true);
        $documentImage = $documentImage->flattenImages();
        $documentImage->setImageFormat($format);
        $documentImage->setColorspace(\Imagick::COLORSPACE_RGB);

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
    private function generateHtml(Asset $asset)
    {
        if (`which pdf2htmlEX`) {
            $newFilename = pathinfo($asset->getFilename(), PATHINFO_FILENAME) . '.html';

            $tempHtmlFile = tempnam(sys_get_temp_dir(), 'pdf2html');
            exec("pdf2htmlEX --dest-dir " . dirname($tempHtmlFile) . ' ' . $asset->getUploadedFile()->getRealPath() . ' ' . basename($tempHtmlFile));

            $handle = fopen($tempHtmlFile, "r");
            $htmlFileContent = fread($handle, filesize($tempHtmlFile));
            fclose($handle);
            unlink($tempHtmlFile);

            if (false === empty($htmlFileContent)) {
                $childAsset = $this->assetFactory->getInstance();
                $childAsset->setStorageType($asset->getStorageType());
                $childAsset->setType($asset->getType());
                $childAsset->setFilename($newFilename);
                $childAsset->setFileContents($htmlFileContent);

                $asset->addChildAsset($childAsset);
                $this->assetStorage->saveAsset($childAsset);
            }
        } else {
            throw new \Exception('pdf2htmlEX is not install');
        }
    }
}
