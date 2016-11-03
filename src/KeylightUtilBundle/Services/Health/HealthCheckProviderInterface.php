<?php
namespace KeylightUtilBundle\Services\Health;

use KeylightUtilBundle\Model\Health\HealthCheck;

interface HealthCheckProviderInterface
{
    /**
     * @return HealthCheck
     */
    public function getHealthCheck();
}
