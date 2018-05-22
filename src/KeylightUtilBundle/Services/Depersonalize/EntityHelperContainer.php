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
        /** @var EntityHelperInterface $helper */
        foreach ($this->helpers as $helper)
        {
            if ($helper->supports($element)) {
                return $helper;
            }
        }

        $elementType = gettype($element);
        if ($elementType !== 'object') {
            throw new OutOfBoundsException(sprintf(
                'Expected object, but element of type "%s" was found', $elementType
            ));
        } else {
            throw new \UnexpectedValueException(sprintf(
                'Helper for the object type "%s" was not found.', get_class($element)
            ));
        }
    }
}
