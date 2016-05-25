<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Groups;
use KeylightUtilBundle\Entity\Asset;
use Doctrine\ORM\Mapping as ORM;
use KeylightUtilBundle\Model\Asset\AssetTypes;

trait AssetsTrait
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="KeylightUtilBundle\Entity\Asset", cascade={"all"})
     *
     * @Serializer\Exclude()
     */
    protected $assets;

    /**
     * @return ArrayCollection
     */
    public function getAssets()
    {
        $assetsAsArray = $this->assets->toArray();
        usort($assetsAsArray, function (Asset $a, Asset $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return new ArrayCollection($assetsAsArray);
    }

    /**
     * @param ArrayCollection $assets
     */
    public function setAssets(ArrayCollection $assets)
    {
        $this->assets = $assets;
    }

    /**
     * @param Asset $asset
     */
    public function addAsset(Asset $asset)
    {
        $this->assets->add($asset);
    }

    /**
     * @return array
     *
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getImages()
    {
        return $this->getAssetsByType(AssetTypes::IMAGE);
    }

    /**
     * @return array
     *
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getVideos()
    {
        return $this->getAssetsByType(AssetTypes::VIDEO);
    }

    /**
     * @return array
     *
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getPdfs()
    {
        return $this->getAssetsByType(AssetTypes::PDF);
    }

    /**
     * @return array
     *
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getAudios()
    {
        return $this->getAssetsByType(AssetTypes::AUDIO);
    }

    /**
     * @param string $type
     * @return array
     */
    protected function getAssetsByType($type)
    {
        $assetsByType = $this->assets->filter(function (Asset $asset) use ($type) {
            return $asset->getType() === $type;
        })->toArray();

        usort($assetsByType, function (Asset $a, Asset $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return $assetsByType;
    }
}
