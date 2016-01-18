<?php
namespace KeylightUtilBundle\Services\Asset\AWS;

use AppBundle\Entity\Asset;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @param S3Client $s3Client
     * @param string $bucket
     */
    public function __construct(S3Client $s3Client, $bucket)
    {
        $this->bucket = $bucket;
        $this->s3Client = $s3Client;
    }

    /**
     * @param Asset $asset
     * @return \Aws\ResultInterface
     */
    public function upload(Asset $asset)
    {
        $asset->setOriginalFileName($asset->getUploadedFile()->getClientOriginalName());
        $ext = $asset->getUploadedFile()->getClientOriginalName();
        $key = sha1(uniqid());
        $newFilename = $key . "." . $ext;
        $asset->setFilename($newFilename);

        return $this->s3Client->upload($this->bucket, $newFilename, $asset->getUploadedFile());
    }
}
