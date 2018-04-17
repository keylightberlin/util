<?php

namespace tests\Services\Depersonalize;

use KeylightUtilBundle\Services\Depersonalize\EntityHelperContainer;
use KeylightUtilBundle\Services\Depersonalize\Helper\EntityHelperInterface;
use PHPUnit\Framework\TestCase;

class EntityHelperContainerTest extends TestCase
{

    public function testGetHelperForEntityClassName()
    {
        $entityHelper = $this->createMock(EntityHelperInterface::class);
        $entityHelper->method('getEntityClass')->willReturn('SomeEntity');

        $entityHelperContainer = new EntityHelperContainer();
        $entityHelperContainer->addHelper($entityHelper);

        $this->assertEquals($entityHelper, $entityHelperContainer->getHelperForEntityClassName('SomeEntity'));
    }

    public function testGetHelperForEntity()
    {
        $entity = new \stdClass();

        $entityHelper = $this->createMock(EntityHelperInterface::class);
        $entityHelper->method('getEntityClass')->willReturn(get_class($entity));

        $entityHelperContainer = new EntityHelperContainer();
        $entityHelperContainer->addHelper($entityHelper);

        $this->assertEquals($entityHelper, $entityHelperContainer->getHelperForEntity($entity));
    }

    public function testAddHelper()
    {
        $entityHelperContainer = new EntityHelperContainer();
        $entityHelper = $this->createMock(EntityHelperInterface::class);
        $entityHelper->expects($this->once())
            ->method('setHelperContainer')
            ->with($this->equalTo($entityHelperContainer));

        $entityHelperContainer->addHelper($entityHelper);

        $this->assertCount(1, $entityHelperContainer->getHelpers());
    }

    public function testGetHelpers()
    {
        $entityHelperContainer = new EntityHelperContainer();
        $entityHelperA = $this->createMock(EntityHelperInterface::class);
        $entityHelperB = $this->createMock(EntityHelperInterface::class);
        $entityHelperC = $this->createMock(EntityHelperInterface::class);

        $entityHelperContainer->addHelper($entityHelperA);
        $entityHelperContainer->addHelper($entityHelperB);
        $entityHelperContainer->addHelper($entityHelperC);

        $this->assertCount(3, $entityHelperContainer->getHelpers());
    }
}
