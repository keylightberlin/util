<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Entity\Repository\AssetRepository;
use KeylightUtilBundle\Model\Asset\AssetTypes;
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
     * @var array
     */
    private $requiredImages;

    /**
     * AssetSanitizer constructor.
     * @param AssetRepository $assetRepository
     * @param AssetProviderInterface $assetProviderInterface
     * @param AssetManagerInterface $assetManager
     * @param EntityManager $entityManager
     * @param array $requiredImages
     */
    public function __construct(
        AssetRepository $assetRepository,
        AssetProviderInterface $assetProviderInterface,
        AssetManagerInterface $assetManager,
        EntityManager $entityManager,
        array $requiredImages
    ) {
        $this->assetRepository = $assetRepository;
        $this->assetProviderInterface = $assetProviderInterface;
        $this->assetManager = $assetManager;
        $this->entityManager = $entityManager;
        $this->requiredImages = $requiredImages;
    }

    /**
     * Regenerates images for the specific sizes determined by the config.
     *
     * @param bool $onlyBroken
     * @param bool $alsoSecure
     * @param int $fromId
     * @param int $toId
     */
    public function regenerateAllAssets($onlyBroken = false, $alsoSecure = false, $fromId = 0, $toId = 100000000)
    {
        $assets = $this->assetRepository->findBaseAssetsForIdsFromTo($fromId, $toId);

        $totalAssetCount = count($assets);
        $i = 0;
        echo "Found " . $totalAssetCount . "\n";

        /** @var Asset $asset */
        foreach ($assets as $asset) {

            echo "Processing asset " . ++$i . " of " . $totalAssetCount . " (id: " . $asset->getId() . ")\n";

            if (
                (
                    $onlyBroken
                    && $asset->getChildAssets()->count() === count($this->requiredImages)
                )
                ||
                (
                    $asset->isSecureStorage() && false === $alsoSecure
                )
            ) {
                echo "Skipping " . $asset->getId() ." because it is completely fine!\n";
                continue;
            }

            if (
                $asset->getType() === AssetTypes::IMAGE
                || $asset->getType() === AssetTypes::PDF
                || in_array($asset->getFileType(), ['png', 'jpg', 'jpeg', 'pdf'])
            ) {
                try {
                    $this->entityManager->persist($asset);
                    $this->regenerateAsset($asset);
                } catch (\Exception $e) {
                    echo $e;
                }
            }

            $this->entityManager->flush();
        }
    }

    /**
     * @param Asset $asset
     */
    public function regenerateAsset(Asset $asset)
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $this->clearSubAssets($asset);
        $assetOriginalFilename =  $this->assetProviderInterface->getUrlForAsset($asset);
        try {
            $file = file_get_contents($assetOriginalFilename, false, stream_context_create($arrContextOptions));
            $localName = "/tmp/" . uniqid();
            file_put_contents($localName, $file);
            $asset->setUploadedFile(new UploadedFile($localName, $asset->getOriginalFileName()));
            $this->assetManager->saveAsset($asset);
            unset($file);
            // exec("rm " . $localName); somehow does not work
            echo "Finished " . $asset->getId() ."\n";
        } catch (\Exception $e) {
            echo "Skipping " . $asset->getId() ." because:\n";
            echo $e->getMessage() . "\n";
        }
    }

    /**
     * @param Asset $asset
     */
    private function clearSubAssets(Asset $asset)
    {
        /** @var Asset $subAsset */
        foreach ($asset->getChildAssets() as $subAsset) {
            $this->entityManager->remove($subAsset, false);
        }

        $this->entityManager->flush();
    }
}
