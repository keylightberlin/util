<?php
namespace KeylightUtilBundle\Services\Asset\Storage\Local;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;

class LocalAssetStorage implements AssetStorageInterface
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
     * @param string $baseDir
     * @param string $subDir
     */
    public function __construct($baseDir, $subDir = self::UPLOADS_BASE_DIR)
    {
        $this->basePath = $baseDir . '/../web/';
        $this->subDir = $subDir;
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    public function saveAsset(Asset $asset)
    {
        if($asset->isPrivateStorage()) {
            $this->subDir .= 'private/';
        }

        $basePath = $this->basePath . "/" . $this->subDir;

        if ($asset->getFile() !== null) {
            file_put_contents($basePath .  $asset->getPath() . $asset->getFilename(), file_get_contents($asset->getFile()->getRealPath()));
            $asset->setPath('/' . $this->subDir);
        }

        return true;
    }

   /* /**
     * @param string $fileName
     * @param string $fileContents
     * @return mixed
     */
    /*public function saveFile($fileName, $fileContents)
    {
        file_put_contents($this->basePath . $fileName, $fileContents);
    }*/

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        unlink($this->basePath . $asset->getRelativeUrl());
    }
}
