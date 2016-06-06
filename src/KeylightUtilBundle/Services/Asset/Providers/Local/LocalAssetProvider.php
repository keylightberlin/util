<?php
namespace KeylightUtilBundle\Services\Asset\Providers\Local;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Providers\AssetProviderInterface;

class LocalAssetProvider implements AssetProviderInterface
{
    const UPLOADS_BASE_DIR = "uploads/";

    /**
     * @var string
     */
    private $basePath;

    /**
    * @var string
    */
    private $subDir;

    /**
     * @var string
     */
    private $baseDir;

    /**
     * @param string $baseDir
     * @param string $subDir
     */
    public function __construct($baseDir, $subDir = self::UPLOADS_BASE_DIR)
    {
        $this->basePath = $baseDir . '/../web/';
        $this->subDir = $subDir;
        $this->baseDir = $baseDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileForAsset(Asset $asset)
    {
        return file_get_contents($this->basePath . $asset->getRelativeUrl());
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlForAsset(Asset $asset)
    {
        return $asset->getRelativeUrl();
    }
}
