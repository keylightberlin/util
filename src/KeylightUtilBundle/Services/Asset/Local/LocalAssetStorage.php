<?php
namespace KeylightUtilBundle\Services\Asset\Local;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\Interfaces\AssetInterface;
use KeylightUtilBundle\Services\Asset\AssetProviderInterface;
use KeylightUtilBundle\Services\Asset\AssetStorageInterface;

class LocalAssetStorage implements AssetStorageInterface, AssetProviderInterface
{
    const UPLOADS_BASE_DIR = "/uploads/";

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param $baseDir
     */
    public function __construct($baseDir)
    {
        $this->basePath = $baseDir . '/../web' . static::UPLOADS_BASE_DIR;
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    public function uploadAsset(Asset $asset)
    {
        $asset->getUploadedFile()->move($this->basePath . $asset->getPath(), $asset->getFilename());

        return true;
    }

    /**
     * @param string $fileName
     * @param string $fileContents
     * @return mixed
     */
    public function uploadFile($fileName, $fileContents)
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

    /**
     * @param AssetInterface $asset
     * @return string
     */
    public function getFileForAsset(AssetInterface $asset)
    {
        return file_get_contents($this->basePath . $asset->getRelativeUrl());
    }

    /**
     * @param AssetInterface $asset
     * @return string
     */
    public function getUrlForAsset(AssetInterface $asset)
    {
        return static::UPLOADS_BASE_DIR . $asset->getRelativeUrl();
    }
}
