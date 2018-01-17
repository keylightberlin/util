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

    public function testGetDayBefore()
    {
        $firstDate = new \DateTime("noon");
        $expectedDate = new \DateTime("noon -1days");
        $result = $this->dateTimeUtil->getDayBefore($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));
    }

    public function testGetDayAfter()
    {
        $firstDate = new \DateTime("noon");
        $expectedDate = new \DateTime("noon +1days");
        $result = $this->dateTimeUtil->getDayAfter($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));
    }

    public function testGetDateAtMidnight()
    {
        $firstDate = new \DateTime("noon");
        $expectedDate = new \DateTime("midnight");
        $result = $this->dateTimeUtil->getDateAtMidnight($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));

        $firstDate = new \DateTime("midnight");
        $expectedDate = new \DateTime("midnight");
        $result = $this->dateTimeUtil->getDateAtMidnight($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));
    }

    public function testGetEndOfDay()
    {
        $firstDate = new \DateTime("noon");
        $expectedDate = new \DateTime("midnight +1days");
        $result = $this->dateTimeUtil->getEndOfDay($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));

        $firstDate = new \DateTime("23:59:59");
        $expectedDate = new \DateTime("midnight +1days");
        $result = $this->dateTimeUtil->getEndOfDay($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));

        $firstDate = new \DateTime("midnight");
        $expectedDate = new \DateTime("midnight +1days");
        $result = $this->dateTimeUtil->getEndOfDay($firstDate);
        $this->assertEquals($expectedDate, $result);
        $this->assertNotEquals(spl_object_hash($firstDate), spl_object_hash($result));
    }

    public function testIsOnSameDay()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("midnight");
        $this->assertTrue($this->dateTimeUtil->isOnSameDay($firstDate, $secondDate));

        $firstDate = new \DateTime("midnight");
        $secondDate = new \DateTime("midnight");
        $this->assertTrue($this->dateTimeUtil->isOnSameDay($firstDate, $secondDate));

        $firstDate = new \DateTime("midnight");
        $secondDate = new \DateTime("midnight +1days");
        $this->assertFalse($this->dateTimeUtil->isOnSameDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertFalse($this->dateTimeUtil->isOnSameDay($firstDate, $secondDate));
    }

    public function testIsTimeEqual()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon");
        $this->assertTrue($this->dateTimeUtil->isTimeEqual($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertTrue($this->dateTimeUtil->isTimeEqual($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1minutes");
        $this->assertFalse($this->dateTimeUtil->isTimeEqual($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1seconds");
        $this->assertTrue($this->dateTimeUtil->isTimeEqual($firstDate, $secondDate));
    }


    public function testIsEarlierOnDay()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon");
        $this->assertFalse($this->dateTimeUtil->isEarlierOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertFalse($this->dateTimeUtil->isEarlierOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours");
        $this->assertTrue($this->dateTimeUtil->isEarlierOnDay($firstDate, $secondDate));
        $this->assertFalse($this->dateTimeUtil->isEarlierOnDay($secondDate, $firstDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours +1days");
        $this->assertTrue($this->dateTimeUtil->isEarlierOnDay($firstDate, $secondDate));
        $this->assertFalse($this->dateTimeUtil->isEarlierOnDay($secondDate, $firstDate));
    }

    public function testIsNotEarlierOnDay()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon");
        $this->assertTrue($this->dateTimeUtil->isNotEarlierOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertTrue($this->dateTimeUtil->isNotEarlierOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours");
        $this->assertFalse($this->dateTimeUtil->isNotEarlierOnDay($firstDate, $secondDate));
        $this->assertTrue($this->dateTimeUtil->isNotEarlierOnDay($secondDate, $firstDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours +1days");
        $this->assertFalse($this->dateTimeUtil->isNotEarlierOnDay($firstDate, $secondDate));
        $this->assertTrue($this->dateTimeUtil->isNotEarlierOnDay($secondDate, $firstDate));
    }

    public function testIsLaterOnDay()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon");
        $this->assertFalse($this->dateTimeUtil->isLaterOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertFalse($this->dateTimeUtil->isLaterOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours");
        $this->assertFalse($this->dateTimeUtil->isLaterOnDay($firstDate, $secondDate));
        $this->assertTrue($this->dateTimeUtil->isLaterOnDay($secondDate, $firstDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours +1days");
        $this->assertFalse($this->dateTimeUtil->isLaterOnDay($firstDate, $secondDate));
        $this->assertTrue($this->dateTimeUtil->isLaterOnDay($secondDate, $firstDate));
    }

    public function testIsNotLaterOnDay()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon");
        $this->assertTrue($this->dateTimeUtil->isNotLaterOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertTrue($this->dateTimeUtil->isNotLaterOnDay($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours");
        $this->assertTrue($this->dateTimeUtil->isNotLaterOnDay($firstDate, $secondDate));
        $this->assertFalse($this->dateTimeUtil->isNotLaterOnDay($secondDate, $firstDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1hours +1days");
        $this->assertTrue($this->dateTimeUtil->isNotLaterOnDay($firstDate, $secondDate));
        $this->assertFalse($this->dateTimeUtil->isNotLaterOnDay($secondDate, $firstDate));
    }

    public function testDifferenceInNumberOfDays()
    {
        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +1days");
        $this->assertEquals(1, $this->dateTimeUtil->getDifferenceInNumberOfDays($firstDate, $secondDate));
        $this->assertEquals(-1, $this->dateTimeUtil->getDifferenceInNumberOfDays($secondDate, $firstDate));

        $firstDate = new \DateTime("midnight");
        $secondDate = new \DateTime("noon");
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInNumberOfDays($firstDate, $secondDate));
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInNumberOfDays($secondDate, $firstDate));

        $firstDate = new \DateTime("midnight");
        $secondDate = new \DateTime("noon -1days");
        $this->assertEquals(-1, $this->dateTimeUtil->getDifferenceInNumberOfDays($firstDate, $secondDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +11hours");
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInNumberOfDays($firstDate, $secondDate));
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInNumberOfDays($secondDate, $firstDate));

        $firstDate = new \DateTime("noon");
        $secondDate = new \DateTime("noon +36hours");
        $this->assertEquals(2, $this->dateTimeUtil->getDifferenceInNumberOfDays($firstDate, $secondDate));
        $this->assertEquals(-2, $this->dateTimeUtil->getDifferenceInNumberOfDays($secondDate, $firstDate));
    }

    public function testTimeDifferenceInSeconds()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+20seconds");
        $this->assertEquals(20, $this->dateTimeUtil->getDifferenceInSeconds($firstDate, $secondDate));
        $this->assertEquals(-20, $this->dateTimeUtil->getDifferenceInSeconds($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = $this->dateTimeUtil->getCopyOfDate($firstDate);
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInSeconds($firstDate, $secondDate));
    }

    public function testTimeDifferenceInMinutes()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+4hours");
        $this->assertEquals(240, $this->dateTimeUtil->getDifferenceInMinutes($firstDate, $secondDate));
        $this->assertEquals(-240, $this->dateTimeUtil->getDifferenceInMinutes($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+12seconds");
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInMinutes($firstDate, $secondDate));
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInMinutes($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = $this->dateTimeUtil->getCopyOfDate($firstDate);
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInMinutes($firstDate, $secondDate));
    }

    public function testTimeDifferenceInHours()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+5days");
        $this->assertEquals(120, $this->dateTimeUtil->getDifferenceInHours($firstDate, $secondDate));
        $this->assertEquals(-120, $this->dateTimeUtil->getDifferenceInHours($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+2minutes");
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInHours($firstDate, $secondDate));
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInHours($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = $this->dateTimeUtil->getCopyOfDate($firstDate);
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInHours($firstDate, $secondDate));
    }

    public function testTimeDifferenceInDays()
    {
        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+35days");
        $this->assertEquals(35, $this->dateTimeUtil->getDifferenceInDays($firstDate, $secondDate));
        $this->assertEquals(-35, $this->dateTimeUtil->getDifferenceInDays($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = new \DateTime("+14hours");
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInDays($firstDate, $secondDate));
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInDays($secondDate, $firstDate));

        $firstDate = new \DateTime();
        $secondDate = $this->dateTimeUtil->getCopyOfDate($firstDate);
        $this->assertEquals(0, $this->dateTimeUtil->getDifferenceInDays($firstDate, $secondDate));
    }
}
