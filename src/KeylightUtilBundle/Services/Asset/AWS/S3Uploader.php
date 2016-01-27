<?php
namespace KeylightUtilBundle\Services\Asset\AWS;

use Aws\ResultInterface;
use KeylightUtilBundle\Entity\Asset;
use Aws\S3\S3Client;

class S3Uploader
{
    /**
     * @var string
     */
    private $bucket;
    /**
     * @var S3Client
     */
    private $s3Client;
    /**
     * @var string
     */
    private $basePath;

    /**
     * @param S3Client $s3Client
     * @param string $bucket
     * @param string $basePath
     */
    public function __construct(S3Client $s3Client, $bucket, $basePath)
    {
        $this->bucket = $bucket;
        $this->s3Client = $s3Client;
        $this->basePath = $basePath;
    }

    /**
     * @param Asset $asset
     * @return ResultInterface
     */
    public function uploadAsset(Asset $asset)
    {
        $asset->setPath($this->basePath . "/");

        return $this->s3Client->upload($this->bucket, $asset->getPath() . $asset->getFilename(), file_get_contents($asset->getUploadedFile()->getRealPath()));
    }

    /**
     * @param string $fileName
     * @param string $fileContents
     * @return ResultInterface
     */
    public function uploadFile($fileName, $fileContents)
    {
        return $this->s3Client->upload($this->bucket, $this->basePath . "/" . $fileName, $fileContents);
    }

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        if (strlen($asset->getRelativeUrl()) > 20) {
            $this->s3Client->deleteObject(
                [
                    'Key' => $asset->getRelativeUrl(),
                    'Bucket' => $this->bucket,
                ]
            );
        }
    }
}
