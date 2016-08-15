<?php
namespace KeylightUtilBundle\Services\Asset\Providers;

use KeylightUtilBundle\Entity\Asset;
use League\Flysystem\Filesystem;

class AssetProvider implements AssetProviderInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var []
     */
    private $assetProviders;
    
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->assetProviders = [];
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function getFileForAsset(Asset $asset)
    {
        $fileContents = null;

        /** @var AssetProviderInterface $assetProvider */
        foreach ($this->assetProviders as $assetProvider) {
            if ($assetProvider->supportsFilesystem($this->filesystem)) {
                $assetProvider->getFileForAsset($asset);
            }
        }

        return $fileContents;
    }

    /**
     * @param Asset $asset
     * @return string
     */
    public function getUrlForAsset(Asset $asset)
    {
        $url = null;

        /** @var AssetProviderInterface $assetProvider */
        foreach ($this->assetProviders as $assetProvider) {
            if ($assetProvider->supportsFilesystem($this->filesystem)) {
                $url = $assetProvider->getUrlForAsset($asset);
            }
        }

        return $url;
    }

    /**
     * @param AssetProviderInterface $assetProvider
     */
    public function addAssetProvider(AssetProviderInterface $assetProvider)
    {
        $this->assetProviders[] = $assetProvider;
    }

    /**
     * @param Filesystem $filesystem
     * @return bool
     */
    public function supportsFilesystem(Filesystem $filesystem)
    {
        return true;
    }
}
