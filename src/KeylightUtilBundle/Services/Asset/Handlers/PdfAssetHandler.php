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

    /**
     * @param AssetStorageInterface $assetStorage
     * @param AssetFactoryInterface $assetFactory
     * @param array $requiredFormats
     */
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
     * @param string $format
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
        $documentImage->setImageFormat($format);
        $documentImage->setColorspace(\Imagick::COLORSPACE_RGB);

        $childAsset = $this->assetFactory->getInstance();
        $childAsset->setStorageType($asset->getStorageType());
        $childAsset->setType($asset->getType());
        $childAsset->setFileType($format);
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
            exec("pdf2htmlEX --zoom 1.3 --dest-dir " . dirname($tempHtmlFile) . ' ' . $asset->getUploadedFile()->getRealPath() . ' ' . basename($tempHtmlFile));

            $htmlFileContent = file_get_contents($tempHtmlFile);
            $htmlFileContent = str_replace("</body>\n</html>", $this->appendStyling(), $htmlFileContent);

            if (false === empty($htmlFileContent)) {
                $childAsset = $this->assetFactory->getInstance();
                $childAsset->setStorageType($asset->getStorageType());
                $childAsset->setType($asset->getType());
                $childAsset->setFileType("html");
                $childAsset->setFilename($newFilename);
                $childAsset->setFileContents($htmlFileContent);

                $asset->addChildAsset($childAsset);
                $this->assetStorage->saveAsset($childAsset);
            }
        } else {
            throw new \Exception('pdf2htmlEX is not installed');
        }
    }

    /**
     * @return string
     */
    private function appendStyling()
    {
        return "
        <style type='text/css'>
    #pf1, #page-container {
        background: white !important;
        -webkit-box-shadow: none!important;
        -moz-box-shadow: none!important;;
        box-shadow: none!important;;
    }
</style>
</body>
</html>
        ";
    }
}
