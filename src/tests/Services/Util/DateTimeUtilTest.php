<?php
namespace tests\Services\Util;

use KeylightUtilBundle\Util\DateTimeUtil;
use PHPUnit\Framework\TestCase;

class DateTimeUtilTest extends TestCase
{
    /**
     * @var DateTimeUtil
     */
    private $dateTimeUtil;

    public function setUp()
    {
        $this->dateTimeUtil = new DateTimeUtil();
    }

    public function testGetCopyOfDate()
    {
        $startDate = new \DateTime();
        $copiedDate = $this->dateTimeUtil->getCopyOfDate($startDate);

        $this->assertEquals($startDate->format('d.m.y'), $copiedDate->format('d.m.y'));
        $this->assertNotEquals(spl_object_hash($startDate), spl_object_hash($copiedDate));
    }
}
