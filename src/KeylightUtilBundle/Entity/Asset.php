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
use KeylightUtilBundle\Model\Asset\AssetStorageTypes;
use KeylightUtilBundle\Model\Asset\AssetTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * The Class to store all information about uploaded assets. If during upload, the assets are processed,
 * the respective assets will be available as childAssets.
 * The predefined serialization groups are
 * - asset_list
 * - asset_details
 * - asset_children
 *
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
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $type;

    /**
     * The name of the type, if it is a processed asset.
     *
     * @var string
     *
     * @ORM\Column(name="processed_type", type="string", length=50, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $processedType;

    /**
     * @var string
     *
     * @ORM\Column(name="storage_type", type="string", length=10, nullable=true)
     *
     * @Exclude()
     */
    private $storageType;

    /**
     * @var Asset
     *
     * @ORM\ManyToOne(targetEntity="KeylightUtilBundle\Entity\Asset", inversedBy="childAssets")
     *
     * @Exclude()
     */
    private $parentAsset;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="KeylightUtilBundle\Entity\Asset", mappedBy="parentAsset", cascade={"all"})
     *
     * @Groups({"asset_children"})
     */
    private $childAssets;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @var string
     */
    private $fileContents;

    /**
     * @var bool
     */
    private $skipProcessing;

    public function __construct()
    {
        $this->childAssets = new ArrayCollection();
        $this->storageType = AssetStorageTypes::PUBLIC_STORAGE;
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
     * @return Asset
     */
    public function getChildAssetByType($type)
    {
        $foundChildAsset = $this;

        /** @var Asset $childAsset */
        foreach ($this->childAssets as $childAsset) {
            if ($childAsset->getType() === $type) {
                $foundChildAsset = $childAsset;
                break;
            }
        }

        return $foundChildAsset;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getRelativeUrlForChildAssetType($type)
    {
        $foundChildAsset = $this->getChildAssetByType($type);

        return $foundChildAsset ? $foundChildAsset->getRelativeUrl() : null;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildAssets()
    {
        return $this->childAssets;
    }

    /**
     * @param ArrayCollection $childAssets
     */
    public function setChildAssets(ArrayCollection $childAssets)
    {
        $this->childAssets = $childAssets;
    }

    /**
     * @param Asset $childAsset
     */
    public function addChildAsset(Asset $childAsset)
    {
        $childAsset->setParentAsset($this);
        $this->childAssets->add($childAsset);
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

    /**
     * @return bool
     */
    public function isPdf()
    {
        return $this->type === AssetTypes::PDF
            || in_array(strtolower(pathinfo($this->originalFileName, PATHINFO_EXTENSION)), ['pdf']);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->filename);
    }

    /**
     * @return bool
     */
    public function isNotEmpty()
    {
        return false === $this->isEmpty();
    }

    /**
     * @return Asset
     */
    public function getParentAsset()
    {
        return $this->parentAsset;
    }

    /**
     * @param Asset $parentAsset
     */
    public function setParentAsset(Asset $parentAsset)
    {
        $this->parentAsset = $parentAsset;
    }

    /**
     * @return bool
     */
    public function isChildAsset()
    {
        return $this->parentAsset !== null;
    }

    /**
     * @return string
     */
    public function getStorageType()
    {
        return $this->storageType;
    }

    /**
     * @param string $storageType
     */
    public function setStorageType($storageType)
    {
        $this->storageType = $storageType;
    }

    /**
     * @return bool
     */
    public function isPublicStorage()
    {
        return $this->storageType === AssetStorageTypes::PUBLIC_STORAGE;
    }

    /**
     * @return bool
     */
    public function isSecureStorage()
    {
        return $this->storageType === AssetStorageTypes::SECURE_STORAGE;
    }

    /**
     * @return string
     */
    public function getProcessedType()
    {
        return $this->processedType;
    }

    /**
     * @param string $processedType
     */
    public function setProcessedType($processedType)
    {
        $this->processedType = $processedType;
    }

    /**
     * @param $processedType
     * @return Asset
     */
    public function getChildAssetByProcessedType($processedType)
    {
        $processedImage = $this;

        /** @var Asset $childAsset */
        foreach ($this->childAssets as $childAsset) {
            if ($childAsset->getProcessedType() === $processedType) {
                $processedImage = $childAsset;
                break;
            }
        }

        return $processedImage;
    }

    /**
     * @return string
     */
    public function getFileContents()
    {
        return $this->fileContents;
    }

    /**
     * @param string $fileContents
     */
    public function setFileContents($fileContents)
    {
        $this->fileContents = $fileContents;
    }

    /**
     * @return bool
     */
    public function isSkipProcessing()
    {
        return $this->skipProcessing;
    }

    /**
     * @param bool $skipProcessing
     */
    public function setSkipProcessing($skipProcessing)
    {
        $this->skipProcessing = $skipProcessing;
    }
}
