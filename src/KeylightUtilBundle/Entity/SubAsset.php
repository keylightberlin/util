<?php
namespace KeylightUtilBundle\Entity;

use Doctrine\Common\Comparable;
use Doctrine\ORM\Mapping as ORM;
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
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=200, nullable=true)
     */
    private $filename;

    /**
     * @var Asset
     *
     * @ORM\ManyToOne(targetEntity="KeylightUtilBundle\Entity\Asset", inversedBy="subAssets")
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
}
