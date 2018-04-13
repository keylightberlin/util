<?php
namespace KeylightUtilBundle\Services\Depersonalize;

use KeylightUtilBundle\Services\Depersonalize\Helper\EntityHelperInterface;
use OutOfBoundsException;

class EntityHelperContainer
{
    /**
     * @var array[EntityHelperInterface]
     */
    private $helpers;

    public function __construct()
    {
        $this->helpers = [];
    }

    /**
     * @param EntityHelperInterface $entityHelper
     */
    public function addHelper(EntityHelperInterface $entityHelper)
    {
        $this->helpers[] = $entityHelper;
        $entityHelper->setHelperContainer($this);
    }

    /**
     * @return array
     */
    public function getHelpers(): array
    {
        return $this->helpers;
    }

    /**
     * @param $element
     * @return EntityHelperInterface
     */
    public function getHelperForEntity($element): EntityHelperInterface
    {
        $elementType = gettype($element);

        if ($elementType !== 'object') {
            throw new OutOfBoundsException(sprintf(
                'Expected object, but element of type "%s" was found', $elementType
            ));
        } else {
            $elementClass = get_class($element);
        }

        return $this->getHelperForEntityClassName($elementClass);
    }

    /**
     * @param string $entityClassName
     * @return EntityHelperInterface
     */
    public function getHelperForEntityClassName(string $entityClassName) {
        /** @var EntityHelperInterface $helper */
        foreach ($this->helpers as $helper)
        {
            if ($entityClassName === $helper->getEntityClass()) {
                return $helper;
            }
        }

        throw new \UnexpectedValueException(sprintf(
            'Helper for the object type "%s" was not found', $entityClassName
        ));
    }

}
