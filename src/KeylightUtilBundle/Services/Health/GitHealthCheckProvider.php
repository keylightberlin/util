<?php
namespace KeylightUtilBundle\Services\Health;

use KeylightUtilBundle\Model\Health\HealthCheck;
use KeylightUtilBundle\Model\Health\HealthCheckStatusTypes;

class GitHealthCheckProvider implements HealthCheckProviderInterface
{
    /**
     * @return HealthCheck
     */
    public function getHealthCheck()
    {
        $commitCode = trim(exec('git log --pretty="%h" -n1 HEAD'));
        $healthCheck = new HealthCheck();
        $healthCheck->setKey("git");
        $healthCheck->setStatus($commitCode ? HealthCheckStatusTypes::OK : HealthCheckStatusTypes::ERROR);
        $healthCheck->addValue("commit", $commitCode);

        return $healthCheck;
    }
}
