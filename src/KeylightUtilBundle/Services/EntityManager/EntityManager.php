<?php
namespace KeylightUtilBundle\Services\EntityManager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class EntityManager
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
     * @param object $entity
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    /**
     *
     */
    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     *
     */
    public function clear()
    {
        $this->entityManager->clear();
    }

    /**
     * @param object $entity
     */
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param object $entity
     * @param bool $doFlush
     */
    public function remove($entity, $doFlush = true)
    {
        $this->entityManager->remove($entity);
        if ($doFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param $className
     * @return ObjectRepository
     */
    public function getRepository($className)
    {
        return $this->entityManager->getRepository($className);
    }
}
