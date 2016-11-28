<?php
namespace KeylightUtilBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('keylight_util')
                ->children()
                    ->arrayNode('email')
                        ->children()
                            ->scalarNode('sender_address')->defaultValue("mail@keylight.de")->end()
                        ->end()
                    ->end()
                    ->arrayNode('aws')
                        ->children()
                            ->scalarNode('s3_access_key_id')->defaultValue('YOUR_ACCESS_KEY_ID')->end()
                            ->scalarNode('s3_secret_access_key')->defaultValue('YOUR_SECRET_ACCESS_KEY')->end()
                            ->scalarNode('s3_bucket')->defaultValue('keylight-dev')->end()
                            ->scalarNode('cloudfront_public_endpoint')->defaultValue('YOUR_PUBLIC_CLOUDFRONT_ENDPOINT')->end()
                            ->scalarNode('cloudfront_secure_endpoint')->defaultValue('YOUR_SECURE_CLOUDFRONT_ENDPOINT')->end()
                            ->scalarNode('cloudfront_private_key')->defaultValue('YOUR_PRIVATE_KEY')->end()
                            ->scalarNode('cloudfront_private_key_pair_id')->defaultValue('YOUR_PRIVATE_KEY_PAIR_ID')->end()
                        ->end()
                    ->end()
                    ->arrayNode('asset')
                        ->children()
                            ->scalarNode('public_base_path')->defaultValue('/uploads/public/')->end()
                            ->scalarNode('secure_base_path')->defaultValue('/uploads/public/')->end()
                            ->scalarNode('folder')->defaultValue('keylight_dev/')->end()
                            ->arrayNode('images')
                                ->defaultValue([])
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->isRequired()->end()
                                        ->scalarNode('long')->defaultValue(0)->end()
                                        ->scalarNode('short')->defaultValue(0)->end()
                                        ->scalarNode('crop')->defaultFalse()->end()
                                        ->scalarNode('quality')->defaultValue(100)->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('pdf')
                                ->defaultValue([])
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('type')->isRequired()->end()
                                        ->scalarNode('resolution')->defaultValue(300)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
