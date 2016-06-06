<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\Repository\AssetRepository;
use KeylightUtilBundle\Services\Asset\Providers\AssetProviderInterface;
use KeylightUtilBundle\Services\EntityManager\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AssetSanitizer
{
    /**
     * @var AssetRepository
     */
    private $assetRepository;
    /**
     * @var AssetProviderInterface
     */
    private $assetProviderInterface;
    /**
     * @var AssetManagerInterface
     */
    private $assetManager;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * AssetSanitizer constructor.
     * @param AssetRepository $assetRepository
     * @param AssetProviderInterface $assetProviderInterface
     * @param AssetManagerInterface $assetManager
     * @param EntityManager $entityManager
     */
    public function __construct(
        AssetRepository $assetRepository,
        AssetProviderInterface $assetProviderInterface,
        AssetManagerInterface $assetManager,
        EntityManager $entityManager
    ) {
        $this->assetRepository = $assetRepository;
        $this->assetProviderInterface = $assetProviderInterface;
        $this->assetManager = $assetManager;
        $this->entityManager = $entityManager;
    }

    /**
     * Regenerates images for the specific sizes determined by the config.
     */
    public function regerateAllAssets()
    {
        $assets = $this->assetRepository->findAll();

        /** @var Asset $asset */
        foreach ($assets as $asset) {
            try {
                $this->regenerateAsset($asset);
            } catch (\Exception $e) {
                echo $e;
            }
        }
    }

    /**
     * @param Asset $asset
     */
    public function regenerateAsset(Asset $asset)
    {
        $this->clearSubAssets($asset);
        $assetOriginalFilename =  $this->assetProviderInterface->getUrlForAsset($asset);
        try {
            $file = file_get_contents($assetOriginalFilename);
            $localName = "/tmp/" . uniqid();
            file_put_contents($localName, $file);
            $asset->setFile(new UploadedFile($localName, $asset->getOriginalFileName()));
            $this->assetManager->saveAsset($asset);
            exec("rm " . $localName);
        } catch (\Exception $e) {
            echo "Skipping";
        }
    }

    /**
     * @param Asset $asset
     */
    private function clearSubAssets(Asset $asset)
    {
        /** @var SubAsset $subAsset */
        foreach ($asset->getChildAssets() as $subAsset) {
            $this->entityManager->remove($subAsset, false);
        }

        $this->entityManager->flush();
    }
}
