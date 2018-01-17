<?php
namespace KeylightUtilBundle\DependencyInjection\CompilerPasses;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AssetProviderCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $assetManager = $container->getDefinition(
            'keylight_util_asset_provider'
        );

        $assetHandlers = $container->findTaggedServiceIds(
            'keylight.asset_provider'
        );
        foreach ($assetHandlers as $id => $tags) {
            foreach ($tags as $attributes) {
                $assetManager->addMethodCall(
                    'addAssetProvider',
                    [new Reference($id)]
                );
            }
        }
    }
}
