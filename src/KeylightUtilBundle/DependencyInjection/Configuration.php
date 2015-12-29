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
                    ->arrayNode('email')->defaultValue([])
                        ->children()
                            ->scalarNode('sender_address')->defaultValue("mail@keylight.de")->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
