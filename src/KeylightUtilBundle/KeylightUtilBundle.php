<?php
namespace KeylightUtilBundle;

use KeylightUtilBundle\DependencyInjection\CompilerPasses\AssetHandlerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KeylightUtilBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AssetHandlerCompilerPass());
    }
}
