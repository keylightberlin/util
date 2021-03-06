<?php
namespace KeylightUtilBundle\Services\Asset\Providers\AWS;

use Aws\CloudFront\CloudFrontClient;
use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Providers\AssetProviderInterface;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class CloudfrontAssetProvider implements AssetProviderInterface
{
    /**
     * @var string
     */
    private $publicCloudfrontEndpoint;
    /**
     * @var CloudFrontClient
     */
    private $cloudFrontClient;
    /**
     * @var string
     */
    private $secureCloudfrontEndpoint;
    /**
     * @var string
     */
    private $privateCloudfrontKey;
    /**
     * @var string
     */
    private $privateCloudfrontKeyPairId;
    /**
     * @var string
     */
    private $publicBasePath;
    /**
     * @var string
     */
    private $secureBasePath;

    /**
     * @param string $publicCloudfrontEndpoint
     * @param string $privateCloudfrontEndpoint
     * @param CloudFrontClient $cloudFrontClient
     * @param string $privateCloudfrontKey
     * @param string $privateCloudfrontKeyPairId
     * @param string $publicBasePath
     * @param string $secureBasePath
     */
    public function __construct(
        $publicCloudfrontEndpoint,
        $privateCloudfrontEndpoint,
        CloudFrontClient $cloudFrontClient,
        $privateCloudfrontKey,
        $privateCloudfrontKeyPairId,
        $publicBasePath,
        $secureBasePath
    ) {
        $this->publicCloudfrontEndpoint = $publicCloudfrontEndpoint;
        $this->cloudFrontClient = $cloudFrontClient;
        $this->secureCloudfrontEndpoint = $privateCloudfrontEndpoint;
        $this->privateCloudfrontKey = $privateCloudfrontKey;
        $this->privateCloudfrontKeyPairId = $privateCloudfrontKeyPairId;
        $this->publicBasePath = $publicBasePath;
        $this->secureBasePath = $secureBasePath;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileForAsset(Asset $asset)
    {
        /**
         * @todo This is very very very very stupid. Does anyone know how to use stream wrappers?
         */
        $fileContents = $this->getFileContentsForAsset($asset);
        $randomName = "/tmp/" . uniqid() . "-" . $asset->getFilename();
        file_put_contents($randomName, $fileContents);
        
        return new File($randomName);
    }

    /**
     * {@inheritdoc}
     */
    public function getFileContentsForAsset(Asset $asset)
    {
        return file_get_contents($this->getUrlForAsset($asset));
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlForAsset(Asset $asset)
    {
        if ($asset->isSecureStorage()) {
            $baseUrl = $this->secureCloudfrontEndpoint;
            $prefixToRemove = $this->secureBasePath;
        } else {
            $baseUrl = $this->publicCloudfrontEndpoint;
            $prefixToRemove = $this->publicBasePath;
        }

        $url = $baseUrl . "/" . substr( $asset->getRelativeUrl(), strlen($prefixToRemove));

        if ($asset->isSecureStorage()) {
            $url = $this->cloudFrontClient->getSignedUrl(
                [
                    'url' => $url,
                    'expires' => time() + 300,
                    'key_pair_id' => $this->privateCloudfrontKeyPairId,
                    'private_key' => $this->privateCloudfrontKey,
                ]
            );
        }

        return $url;
    }

    /**
     * @param Filesystem $filesystem
     * @return boolean
     */
    public function supportsFilesystem(Filesystem $filesystem)
    {
        return $filesystem->getAdapter() instanceof AwsS3Adapter;
    }
}
