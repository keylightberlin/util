<?php
namespace KeylightUtilBundle\Services\Uuid;

use KeylightUtilBundle\Services\EntityManager\EntityManager;
use KeylightUtilBundle\Services\String\RandomStringUtil;

class UuidProvider implements UuidProviderInterface
{
    const UUID_LENGTH = 10;

    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var RandomStringUtil
     */
    private $randomStringUtil;

    /**
     * @param EntityManager $entityManager
     * @param RandomStringUtil $randomStringUtil
     */
    public function __construct(EntityManager $entityManager, RandomStringUtil $randomStringUtil)
    {
        $this->entityManager = $entityManager;
        $this->randomStringUtil = $randomStringUtil;
    }

    /**
     * {@inheritdoc}
     */
    public function getUuidForClass($className)
    {
        $entityRepository = $this->entityManager->getRepository($className);

        do {
            $uuid = $this->randomStringUtil->getRandomString(static::UUID_LENGTH);
            $existingEntity = $entityRepository->findOneBy([ 'uuid' => $uuid ]);
        } while ($existingEntity !== null);

        return $uuid;
    }
}

