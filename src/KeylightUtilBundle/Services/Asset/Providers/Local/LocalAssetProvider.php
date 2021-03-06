<?php
namespace KeylightUtilBundle\Services\Asset\Providers\Local;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Providers\AssetProviderInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class LocalAssetProvider implements AssetProviderInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileForAsset(Asset $asset)
    {
        /** @var Local $localAdapter */
        $localAdapter = $this->filesystem->getAdapter();

        return new File($localAdapter->getPathPrefix() . $this->getUrlForAsset($asset));
    }

    /**
     * {@inheritdoc}
     */
    public function getFileContentsForAsset(Asset $asset)
    {
        /** @var Local $localAdapter */
        $localAdapter = $this->filesystem->getAdapter();

        return file_get_contents($localAdapter->getPathPrefix() . $this->getUrlForAsset($asset));
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlForAsset(Asset $asset)
    {
        return $asset->getRelativeUrl();
    }

    /**
     * @param Filesystem $filesystem
     * @return boolean
     */
    public function supportsFilesystem(Filesystem $filesystem)
    {
        return $filesystem->getAdapter() instanceof Local;
    }
}
