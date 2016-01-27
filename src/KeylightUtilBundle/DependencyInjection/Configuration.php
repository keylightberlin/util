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
                            ->scalarNode('s3_base_path')->defaultValue('default')->end()
                            ->scalarNode('cloudfront_endpoint')->defaultValue('YOUR_CLOUDFRONT_ENDPOINT')->end()
                        ->end()
                    ->end()
                    ->arrayNode('asset')
                        ->children()
                            ->arrayNode('images')
                                ->defaultValue([])
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->isRequired()->end()
                                        ->scalarNode('height')->defaultValue(0)->end()
                                        ->scalarNode('width')->defaultValue(0)->end()
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
