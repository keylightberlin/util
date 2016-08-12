<?php
namespace KeylightUtilBundle\Services\Asset\Providers;

use KeylightUtilBundle\Entity\Asset;
use League\Flysystem\Filesystem;

interface AssetProviderInterface
{
    /**
     * @param Asset $asset
     * @return string
     */
    public function getFileForAsset(Asset $asset);

    /**
     * @param Asset $asset
     * @return string
     */
    public function getUrlForAsset(Asset $asset);

    /**
     * @param Filesystem $filesystem
     * @return boolean
     */
    public function supportsFilesystem(Filesystem $filesystem);
}
