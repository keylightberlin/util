<?php

namespace KeylightUtilBundle\Services\Depersonalize;

use KeylightUtilBundle\Services\Depersonalize\Helper\EntityHelperInterface;

class Depersonalize
{
    /**
     * @var EntityHelperContainer
     */
    private $helperContainer;

    /**
     * @param EntityHelperContainer $helperContainer
     */
    public function __construct(EntityHelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
    }

    public function run() {

        /** @var EntityHelperInterface $helper */
        foreach ($this->helperContainer->getHelpers() as $helper) {

            $helper->depersonalizeAll();
        }
    }
}
