<?php
namespace KeylightUtilBundle\Services\Health;

use KeylightUtilBundle\Model\Health\HealthCheck;
use KeylightUtilBundle\Model\Health\HealthCheckStatusTypes;

class HealthCheckProvider implements HealthCheckProviderInterface
{
    const STATUS_KEY = "status";
    const CHECKS_KEY = "checks";
    const MAIN_CHECK_NAME = "main";

    /**
     * @var array
     */
    private $healthCheckers;

    public function __construct()
    {
        $this->healthCheckers = [];
    }

    /**
     * @return HealthCheck
     */
    public function getHealthCheck()
    {
        $mainHealthCheck = new HealthCheck();
        $mainHealthCheck->setKey(static::MAIN_CHECK_NAME);
        $healthChecks = $this->getHealthChecks();

        /** @var HealthCheck $healthCheck */
        foreach ($healthChecks as $healthCheck) {
            $mainHealthCheck->addValue(
                $healthCheck->getKey(),
                [
                    static::STATUS_KEY => $healthCheck->getStatus(),
                    static::CHECKS_KEY => $healthCheck->getValues(),
                ]
            );
        }

        $mainHealthCheck->setStatus($this->getOverallStatusForHealthChecks($healthChecks));

        return $mainHealthCheck;
    }

    /**
     * @return array
     */
    public function getHealthCheckAsArray()
    {
        $healthCheck = $this->getHealthCheck();

        return [
            $healthCheck->getKey(),
            [
                static::STATUS_KEY => $healthCheck->getStatus(),
                static::CHECKS_KEY => $healthCheck->getValues(),
            ]
        ];
    }

    /**
     * @return array
     */
    private function getHealthChecks()
    {
        $healthChecks = [];

        /** @var HealthCheckProviderInterface $healthChecker */
        foreach ($this->healthCheckers as $healthChecker) {
            $healthChecks[] = $healthChecker->getHealthCheck();
        }

        return $healthChecks;
    }

    /**
     * @param HealthCheckProviderInterface $healthChecker
     */
    public function registerHealthCheckProvider(HealthCheckProviderInterface $healthChecker)
    {
        $this->healthCheckers[] = $healthChecker;
    }

    /**
     * @param array $healthChecks
     * @return string
     */
    private function getOverallStatusForHealthChecks(array $healthChecks)
    {
        $overallStatus = HealthCheckStatusTypes::OK;

        $statusArray = array_map(
            function (HealthCheck $healthCheck) {
                return $healthCheck->getStatus();
            },
            $healthChecks
        );

        if (in_array(HealthCheckStatusTypes::ERROR, $statusArray)) {
            $overallStatus = HealthCheckStatusTypes::ERROR;
        } elseif (in_array(HealthCheckStatusTypes::WARNING, $statusArray)) {
            $overallStatus = HealthCheckStatusTypes::WARNING;
        }

        return $overallStatus;
    }
}
