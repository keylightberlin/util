<?php
namespace KeylightUtilBundle\Entity;

use Doctrine\Common\Comparable;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use KeylightUtilBundle\Entity\Traits\ActiveTrait;
use KeylightUtilBundle\Entity\Traits\IdTrait;
use KeylightUtilBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity()
 * @ORM\Table(name="keylight_sub_asset")
 */
class SubAsset
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_asset_type", type="string", length=50, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=200, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $filename;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $width;

    /**
     * @var Asset
     *
     * @ORM\ManyToOne(targetEntity="KeylightUtilBundle\Entity\Asset", inversedBy="subAssets")
     *
     * @Exclude()
     */
    private $asset;

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     */
    public function setAsset(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return string
     */
    public function getRelativeUrl()
    {
        return $this->getAsset()->getPath() . $this->getFilename();
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
}
