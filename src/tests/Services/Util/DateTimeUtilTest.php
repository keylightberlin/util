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

    public function testTimeDifferenceInSeconds()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+20seconds");

        $this->assertEquals(20, $this->dateTimeUtil->getDifferenceInSeconds($firstDate, $secondDate));
    }

    public function testTimeDifferenceInMinutes()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+4hours");

        $this->assertEquals(240, $this->dateTimeUtil->getDifferenceInMinutes($firstDate, $secondDate));

        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+12seconds");

        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInMinutes($firstDate, $secondDate));
    }

    public function testTimeDifferenceInHours()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+5days");

        $this->assertEquals(120, $this->dateTimeUtil->getDifferenceInHours($firstDate, $secondDate));

        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+2minutes");

        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInHours($firstDate, $secondDate));
    }

    public function testTimeDifferenceInDays()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+35days");

        $this->assertEquals(35, $this->dateTimeUtil->getDifferenceInDays($firstDate, $secondDate));

        $firstDate = new \DateTime("midnight");
        $secondDate = new \DateTime("midnight");
        $secondDate->modify("+14hours")->modify("+35Days");

        $this->assertEquals(35, $this->dateTimeUtil->getDifferenceInDays($firstDate, $secondDate));
    }
}
