<?php
namespace KeylightUtilBundle\Services\Asset\Storage\Local;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;

class LocalAssetStorage implements AssetStorageInterface
{
    const UPLOADS_BASE_DIR = "/uploads/";

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param string $baseDir
     * @param string $subDir
     */
    public function __construct($baseDir, $subDir = self::UPLOADS_BASE_DIR)
    {
        $this->basePath = $baseDir . '/../web' . $subDir;
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    public function saveAsset(Asset $asset)
    {
        $asset->getFile()->move($this->basePath . $asset->getPath(), $asset->getFilename());

        return true;
    }

    /**
     * @param string $fileName
     * @param string $fileContents
     * @return mixed
     */
    public function saveFile($fileName, $fileContents)
    {
        file_put_contents($this->basePath . $fileName, $fileContents);
    }

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        unlink($this->basePath . $asset->getRelativeUrl());
    }
}
