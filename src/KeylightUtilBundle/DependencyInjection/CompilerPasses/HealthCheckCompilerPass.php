<?php
namespace KeylightUtilBundle\DependencyInjection\CompilerPasses;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HealthCheckCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $healthCheckProvider = $container->getDefinition(
            'keylight_util_health_check_provider'
        );

        $healthCheckProviders = $container->findTaggedServiceIds(
            'keylight_util.health_check'
        );
        foreach ($healthCheckProviders as $id => $tags) {
            foreach ($tags as $attributes) {
                $healthCheckProvider->addMethodCall(
                    'registerHealthCheckProvider',
                    [new Reference($id)]
                );
            }
        }
    }
}
