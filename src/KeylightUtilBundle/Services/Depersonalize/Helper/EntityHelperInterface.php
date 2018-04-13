<?php
namespace KeylightUtilBundle\Services\Depersonalize\Helper;

use KeylightUtilBundle\Services\Depersonalize\EntityHelperContainer;

interface EntityHelperInterface
{
    public function getEntityClass(): string;

    public function setHelperContainer(EntityHelperContainer $helperContainer): void;

    public function depersonalizeItem($item);

    public function depersonalizeAll(): void;
}
