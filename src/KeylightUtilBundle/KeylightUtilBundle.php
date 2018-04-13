<?php
namespace KeylightUtilBundle;

use KeylightUtilBundle\DependencyInjection\CompilerPasses\DepersonalizePass;
use KeylightUtilBundle\DependencyInjection\CompilerPasses\AssetHandlerCompilerPass;
use KeylightUtilBundle\DependencyInjection\CompilerPasses\AssetProviderCompilerPass;
use KeylightUtilBundle\DependencyInjection\CompilerPasses\HealthCheckCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KeylightUtilBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AssetHandlerCompilerPass());
        $container->addCompilerPass(new AssetProviderCompilerPass());
        $container->addCompilerPass(new HealthCheckCompilerPass());
        $container->addCompilerPass(new DepersonalizePass());
    }
}
