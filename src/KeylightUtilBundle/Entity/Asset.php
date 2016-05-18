<?php
namespace KeylightUtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use KeylightUtilBundle\Entity\Interfaces\AssetInterface;
use KeylightUtilBundle\Entity\Traits\ActiveTrait;
use KeylightUtilBundle\Entity\Traits\IdTrait;
use KeylightUtilBundle\Entity\Traits\TimestampableTrait;
use KeylightUtilBundle\Model\Asset\AssetTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="KeylightUtilBundle\Entity\Repository\AssetRepository")
 * @ORM\Table(name="keylight_asset")
 * @ORM\HasLifecycleCallbacks()
 */
class Asset implements Translatable, AssetInterface
{
    use IdTrait;
    use TimestampableTrait;
    use ActiveTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="file_type", type="string", length=50, nullable=true)
     *
     * @Groups({"asset_details"})
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=200, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $filename;

    /**
     * The relative path.
     *
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=200, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="original_file_name", type="string", length=200, nullable=true)
     *
     * @Exclude()
     */
    private $originalFileName;

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
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     *
     * @Exclude()
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     *
     * @Gedmo\Translatable()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="KeylightUtilBundle\Entity\SubAsset", mappedBy="asset", cascade={"all"})
     *
     * @Groups({"asset_details"})
     */
    private $subAssets;

    public function __construct()
    {
        $this->subAssets = new ArrayCollection();
    }

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
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return string
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    /**
     * @param string $originalFileName
     */
    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getRelativeUrl()
    {
        return $this->path . $this->filename;
    }

    /**
     * @param string $type
     * @return SubAsset
     */
    public function getSubAssetByType($type)
    {
        $foundSubAsset = null;

        /** @var SubAsset $subAsset */
        foreach ($this->subAssets as $subAsset) {
            if ($subAsset->getType() === $type) {
                $foundSubAsset = $subAsset;
                break;
            }
        }

        return $foundSubAsset;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getRelativeUrlForSubAssetType($type)
    {
        $foundSubAssetUrl = null;

        /** @var SubAsset $subAsset */
        foreach ($this->subAssets as $subAsset) {
            if ($subAsset->getType() === $type) {
                $foundSubAssetUrl = $subAsset->getRelativeUrl();
                break;
            }
        }

        return $foundSubAssetUrl;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubAssets()
    {
        return $this->subAssets;
    }

    /**
     * @param ArrayCollection $subAssets
     */
    public function setSubAssets(ArrayCollection $subAssets)
    {
        $this->subAssets = $subAssets;
    }

    /**
     * @param SubAsset $subAsset
     */
    public function addSubAsset(SubAsset $subAsset)
    {
        $subAsset->setAsset($this);
        $this->subAssets->add($subAsset);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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

    /**
     * @return bool
     */
    public function isImage()
    {
        return $this->type === AssetTypes::IMAGE
            || in_array(strtolower(pathinfo($this->originalFileName, PATHINFO_EXTENSION)), ['jpg', 'png', 'gif', 'jpeg', 'bmp', 'tif']);
    }
}
