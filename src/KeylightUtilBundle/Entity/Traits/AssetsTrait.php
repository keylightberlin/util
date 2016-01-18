<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use KeylightUtilBundle\Entity\Asset;
use Doctrine\ORM\Mapping as ORM;
use KeylightUtilBundle\Model\Asset\AssetTypes;

trait AssetsTrait
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="KeylightUtilBundle\Entity\Asset", cascade={"all"})
     */
    protected $assets;

    /**
     * @return ArrayCollection
     */
    public function getAssets()
    {
        return $this->assets;
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
     * @return Collection
     */
    public function getImages()
    {
        $images = $this->assets->filter(function (Asset $asset) {
            return $asset->getType() === AssetTypes::IMAGE;
        })->toArray();

        usort($images, function (Asset $a, Asset $b) {
            return $a->getPriority() < $b->getPriority();
        });

        return $images;
    }

    /**
     * @return Collection
     */
    public function getVideos()
    {
        $videos = $this->assets->filter(function (Asset $asset) {
            return $asset->getType() === AssetTypes::VIDEO;
        })->toArray();

        usort($videos, function (Asset $a, Asset $b) {
            return $a->getPriority() < $b->getPriority();
        });

        return $videos;
    }

    /**
     * @return Collection
     */
    public function getPdfs()
    {
        $pdfs = $this->assets->filter(function (Asset $asset) {
            return $asset->getType() === AssetTypes::PDF;
        })->toArray();

        usort($pdfs, function (Asset $a, Asset $b) {
            return $a->getPriority() < $b->getPriority();
        });

        return $pdfs;
    }
}
