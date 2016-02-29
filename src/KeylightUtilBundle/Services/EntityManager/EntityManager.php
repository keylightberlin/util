<?php
namespace KeylightUtilBundle\Services\EntityManager;

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
     * @param object $entity
     */
    public function flush($entity = null)
    {
        $this->entityManager->flush($entity);
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
}
