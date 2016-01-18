<?php
namespace KeylightUtilBundle\Entity;

use Doctrine\Common\Comparable;
use Doctrine\ORM\Mapping as ORM;
use KeylightUtilBundle\Entity\Traits\ActiveTrait;
use KeylightUtilBundle\Entity\Traits\IdTrait;
use KeylightUtilBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="KeylightUtilBundle\Entity\Repository\AssetRepository")
 * @ORM\Table(name="keylight_asset")
 * @ORM\HasLifecycleCallbacks()
 */
class Asset
{
    use IdTrait;
    use TimestampableTrait;
    use ActiveTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="file_type", type="string", length=50, nullable=true)
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=200, nullable=true)
     */
    private $filename;

    /**
     * The relative path.
     *
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=200, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="original_file_name", type="string", length=200, nullable=true)
     */
    private $originalFileName;

    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     */
    private $type;

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
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
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
}