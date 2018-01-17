<?php
namespace KeylightUtilBundle\DependencyInjection\CompilerPasses;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AssetHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $assetManager = $container->getDefinition(
            'keylight_util_asset_manager'
        );

        $assetHandlers = $container->findTaggedServiceIds(
            'keylight.asset_handler'
        );
        foreach ($assetHandlers as $id => $tags) {
            foreach ($tags as $attributes) {
                $assetManager->addMethodCall(
                    'addAssetHandler',
                    [new Reference($id), $attributes['priority']]
                );
            }
        }
    }
}
