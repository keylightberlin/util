<?php
namespace KeylightUtilBundle\Services\Asset\Providers\AWS;

use Aws\CloudFront\CloudFrontClient;
use KeylightUtilBundle\Entity\Asset;
use KeylightUtilBundle\Services\Asset\Providers\AssetProviderInterface;

class CloudfrontAssetProvider implements AssetProviderInterface
{
    /**
     * @var string
     */
    private $cloudfrontEndpoint;
    /**
     * @var CloudFrontClient
     */
    private $cloudFrontClient;

    /**
     * @param string $cloudfrontEndpoint
     * @param CloudFrontClient $cloudFrontClient
     */
    public function __construct($cloudfrontEndpoint, CloudFrontClient $cloudFrontClient)
    {
        $this->cloudfrontEndpoint = $cloudfrontEndpoint;
        $this->cloudFrontClient = $cloudFrontClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileForAsset(Asset $asset)
    {
        return file_get_contents($this->getUrlForAsset($asset));
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlForAsset(Asset $asset)
    {
        $url = $this->cloudfrontEndpoint . "/" . $asset->getRelativeUrl();

        if ($asset->isPrivateStorage()) {
            $url = $this->cloudFrontClient->getSignedUrl([ 'url' => $url, 'expires' => 60 ]);
        }

        return $url;
    }
}
