<?php
namespace KeylightUtilBundle\Services\Asset\Providers\AWS;

use Aws\CloudFront\CloudFrontClient;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class CloudfrontClientFactory
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $secret;

    /**
     * @param string $key
     * @param string $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @return S3Client
     */
    public function getInstance()
    {
        $credentials = new Credentials($this->key, $this->secret);
        return new CloudFrontClient(
            [
                'credentials' => $credentials,
                'region' => 'eu-central-1',
                'version' => '2009-09-09',
            ]
        );
    }
}
