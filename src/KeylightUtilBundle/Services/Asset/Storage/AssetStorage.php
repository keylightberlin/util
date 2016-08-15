<?php
namespace KeylightUtilBundle\Services\Asset\Storage;

use KeylightUtilBundle\Entity\Asset;
use League\Flysystem\Filesystem;

class AssetStorage implements AssetStorageInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var
     */
    private $publicBasePath;
    /**
     * @var
     */
    private $secureBasePath;
    /**
     * @var string
     */
    private $folder;

    /**
     * @param Filesystem $filesystem
     * @param string $publicBasePath
     * @param string $secureBasePath
     * @param string $folder
     */
    public function __construct(Filesystem $filesystem, $publicBasePath, $secureBasePath, $folder)
    {
        $this->filesystem = $filesystem;
        $this->publicBasePath = $publicBasePath;
        $this->secureBasePath = $secureBasePath;
        $this->folder = $folder;
    }
    
    /**
     * {@inheritdoc}
     */
    public function saveAsset(Asset $asset)
    {
        $saveBasePath = $asset->isPublicStorage() ? $this->publicBasePath : $this->secureBasePath;

        $asset->setPath($saveBasePath . $this->folder);
        $fileContents = $asset->getFileContents() ?: file_get_contents($asset->getUploadedFile()->getRealPath());

        $putStream = tmpfile();
        fwrite($putStream, $fileContents);
        rewind($putStream);
        $this->filesystem->putStream($asset->getRelativeUrl(), $putStream);

        if (is_resource($putStream)) {
            fclose($putStream);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAsset(Asset $asset)
    {
        $saveBasePath = $asset->isPublicStorage() ? $this->publicBasePath : $this->secureBasePath;
        
        if ($this->filesystem->has($saveBasePath . $asset->getRelativeUrl())) {
            $this->filesystem->delete($saveBasePath . $asset->getRelativeUrl());            
        }
    }
}
