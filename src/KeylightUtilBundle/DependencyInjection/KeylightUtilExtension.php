<?php
namespace KeylightUtilBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class KeylightUtilExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('keylight_util_sender_address', $config['email']['sender_address']);
        $container->setParameter('keylight_util_s3_access_key_id', $config['aws']['s3_access_key_id']);
        $container->setParameter('keylight_util_s3_secret_access_key', $config['aws']['s3_secret_access_key']);
        $container->setParameter('keylight_util_s3_public_bucket', $config['aws']['s3_public_bucket']);
        $container->setParameter('keylight_util_s3_public_base_path', $config['aws']['s3_public_base_path']);
        $container->setParameter('keylight_util_cloudfront_public_endpoint', $config['aws']['cloudfront_public_endpoint']);
        $container->setParameter('keylight_util_s3_private_bucket', $config['aws']['s3_private_bucket']);
        $container->setParameter('keylight_util_s3_private_base_path', $config['aws']['s3_private_base_path']);
        $container->setParameter('keylight_util_cloudfront_private_endpoint', $config['aws']['cloudfront_private_endpoint']);
        $container->setParameter('keylight_util_cloudfront_private_key', $config['aws']['cloudfront_private_key']);
        $container->setParameter('keylight_util_cloudfront_private_key_pair_id', $config['aws']['cloudfront_private_key_pair_id']);

        $container->setParameter('keylight_util_asset_images', $config['asset']['images']);
        $container->setParameter('keylight_util_local_storage_subdir', $config['asset']['local_storage_subdir']);

        if ($config['asset']['storage'] === 'aws') {
            $container->setAlias('keylight_util_asset_storage', 'keylight_s3_uploader');
            $container->setAlias('keylight_util_asset_provider', 'keylight_cloudfront_asset_provider');
        } elseif ($config['asset']['storage'] === 'local') {
            $container->setAlias('keylight_util_asset_storage', 'keylight_local_asset_storage');
            $container->setAlias('keylight_util_asset_provider', 'keylight_local_asset_provider');
        } else {
            throw new \Exception("Unknown asset provider");
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
