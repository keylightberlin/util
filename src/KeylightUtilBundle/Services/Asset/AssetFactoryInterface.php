<?php
namespace KeylightUtilBundle\Services\Asset;

use KeylightUtilBundle\Entity\Asset;

interface AssetFactoryInterface
{
    /**
     * @return Asset
     */
    public function getInstance();
}
