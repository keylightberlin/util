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
        $container->setParameter('keylight_util_s3_bucket', $config['aws']['s3_bucket']);
        $container->setParameter('keylight_util_s3_base_path', $config['aws']['s3_base_path']);
        $container->setParameter('keylight_util_cloudfront_endpoint', $config['aws']['cloudfront_endpoint']);

        $container->setParameter('keylight_util_asset_images', $config['asset']['images']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
