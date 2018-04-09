<?php
namespace KeylightUtilBundle\Services\Health;

use Doctrine\ORM\EntityManagerInterface;
use KeylightUtilBundle\Model\Health\HealthCheck;
use KeylightUtilBundle\Model\Health\HealthCheckStatusTypes;

class DBHealthCheckProvider implements HealthCheckProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return HealthCheck
     */
    public function getHealthCheck()
    {
        $healthCheck = new HealthCheck();
        $healthCheck->setStatus(HealthCheckStatusTypes::OK);
        $healthCheck->setKey("db");

        try {
            $this->entityManager->getConnection();
            $healthCheck->addValue("connection", HealthCheckStatusTypes::OK);
        } catch (\Exception $exception) {
            $healthCheck->setStatus(HealthCheckStatusTypes::ERROR);
            $healthCheck->addValue("connection", HealthCheckStatusTypes::ERROR);
        }

        return $healthCheck;
    }
}
