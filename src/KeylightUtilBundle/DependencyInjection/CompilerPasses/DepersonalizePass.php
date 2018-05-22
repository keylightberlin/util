<?php
namespace KeylightUtilBundle\DependencyInjection\CompilerPasses;

use KeylightUtilBundle\Services\Depersonalize\EntityHelperContainer;
use KeylightUtilBundle\Services\Depersonalize\Helper\EntityHelperInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DepersonalizePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(EntityHelperContainer::class)) {
            return;
        }

        $definition = $container->findDefinition(EntityHelperContainer::class);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds(EntityHelperInterface::class);

        foreach ($taggedServices as $id => $tags) {

            // add the transport service to the ChainTransport service
            $definition->addMethodCall('addHelper', [new Reference($id)]);
        }
    }
}
