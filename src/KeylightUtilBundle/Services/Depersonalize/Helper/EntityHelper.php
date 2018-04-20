<?php

namespace KeylightUtilBundle\Services\Depersonalize\Helper;

use KeylightUtilBundle\Services\Depersonalize\EntityHelperContainer;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OutOfBoundsException;

abstract class EntityHelper implements EntityHelperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntityHelperContainer
     */
    protected $helperContainer;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EntityHelperContainer $helperContainer
     */
    public function setHelperContainer(EntityHelperContainer $helperContainer): void
    {
        $this->helperContainer = $helperContainer;
    }

    /**
     * @return string
     */
    public abstract function getEntityClass(): string;

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->getEntityClass());
    }

    protected abstract function depersonalizeData($item);

    /**
     * @param $item
     */
    public function depersonalizeItem($item)
    {
        $this->ensureSupportedElement($item);
        $this->depersonalizeData($item);
        $this->entityManager->persist($item);
        return $item;
    }

    public function depersonalizeAll(): void
    {
        foreach ($this->getRepository()->findAll() as $item){
            $this->depersonalizeItem($item);
        }

        $this->entityManager->flush();
    }

    /**
     * @param $element
     */
    protected function ensureSupportedElement($element): void
    {
        $requiredClass = $this->getEntityClass();
        $elementType = gettype($element);

        if ($elementType !== 'object') {
            throw new OutOfBoundsException(sprintf(
                'Expected object of class "%s", but element of type "%s" was found', $requiredClass, $elementType
            ));
        } else {
            $elementClass = get_class($element);

            if (! $element instanceof $requiredClass) {
                throw new OutOfBoundsException(sprintf(
                    'Expected object of class "%s", but object of class "%s" was found', $requiredClass, $elementClass
                ));
            }
        }
    }

    public function supports($element): bool
    {
        $supports = false;

        $requiredClass = $this->getEntityClass();
        $elementType = gettype($element);

        if ($elementType === 'object' && $element instanceof $requiredClass) {
            $supports = true;
        }
        return $supports;
    }
}
