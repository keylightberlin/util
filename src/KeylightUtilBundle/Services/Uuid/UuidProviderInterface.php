<?php
namespace KeylightUtilBundle\Services\Uuid;

interface UuidProviderInterface
{
    /**
     * @param string $className
     * @return string
     */
    public function getUuidForClass($className);
}
