<?php
namespace KeylightUtilBundle\Services\Asset\Storage\AWS;

use Aws\ResultInterface;
use KeylightUtilBundle\Entity\Asset;
use Aws\S3\S3Client;
use KeylightUtilBundle\Services\Asset\Storage\AssetStorageInterface;

class S3Uploader implements AssetStorageInterface
{
    /**
     * @var string
     */
    private $publicBucket;
    /**
     * @var S3Client
     */
    private $s3Client;
    /**
     * @var string
     */
    private $publicBasePath;
    /**
     * @var string
     */
    private $privateBasePath;
    /**
     * @var string
     */
    private $privateBucket;

    /**
     * @param S3Client $s3Client
     * @param string $publicBucket
     * @param string $publicBasePath
     * @param string $privateBucket
     * @param string $privateBasePath
     */
    public function __construct(S3Client $s3Client, $publicBucket, $publicBasePath, $privateBucket, $privateBasePath)
    {
        $this->publicBucket = $publicBucket;
        $this->s3Client = $s3Client;
        $this->publicBasePath = $publicBasePath;
        $this->privateBasePath = $privateBasePath;
        $this->privateBucket = $privateBucket;
    }

    /**
     * @param Asset $asset
     * @return ResultInterface
     */
    public function saveAsset(Asset $asset)
    {
        if ($asset->isPrivateStorage()) {
            $bucket = $this->privateBucket;
            $path = $this->privateBasePath;
        } else {
            $bucket = $this->publicBucket;
            $path = $this->publicBasePath;
        }

        $asset->setPath($path . "/");

        $fileContents = $asset->getFileContents() ?: file_get_contents($asset->getFile()->getRealPath());

        return $this->s3Client->upload($bucket, $asset->getPath() . $asset->getFilename(), $fileContents);
    }

    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        if ($asset->isPrivateStorage()) {
            $bucket = $this->privateBucket;
        } else {
            $bucket = $this->publicBucket;
        }

        if (strlen($asset->getRelativeUrl()) > 20) {
            $this->s3Client->deleteObject(
                [
                    'Key' => $asset->getRelativeUrl(),
                    'Bucket' => $bucket,
                ]
            );
        }
    }
}
