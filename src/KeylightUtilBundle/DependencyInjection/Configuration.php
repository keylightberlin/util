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
                            ->scalarNode('s3_public_bucket')->defaultValue('keylight-dev')->end()
                            ->scalarNode('s3_public_base_path')->defaultValue('default')->end()
                            ->scalarNode('s3_private_bucket')->defaultValue('keylight-dev-private')->end()
                            ->scalarNode('s3_private_base_path')->defaultValue('default')->end()
                            ->scalarNode('cloudfront_public_endpoint')->defaultValue('YOUR_PUBLIC_CLOUDFRONT_ENDPOINT')->end()
                            ->scalarNode('cloudfront_private_endpoint')->defaultValue('YOUR_PRIVATE_CLOUDFRONT_ENDPOINT')->end()
                        ->end()
                    ->end()
                    ->arrayNode('asset')
                        ->children()
                            ->scalarNode('storage')->defaultValue('aws')->end() // or local
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
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
