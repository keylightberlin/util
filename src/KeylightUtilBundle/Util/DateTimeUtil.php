<?php
namespace KeylightUtilBundle\Util;

/**
 * A class for easily duplicating and comparing dates. Never alters the date passed to the function.
 */
final class DateTimeUtil
{
    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getCopyOfDate(\DateTime $dateTime)
    {
        return clone $dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @param string $modification
     * @return \DateTime
     */
    public static function getModifiedDate(\DateTime $dateTime, $modification)
    {
        $newDateTime = clone $dateTime;
        $newDateTime->modify($modification);

        return $newDateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDayBefore(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "-1 day");
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDayAfter(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "+1 day");
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDateAtMidnight(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "midnight");
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getStartOfDay(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "midnight");
    }
    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getEndOfDay(\DateTime $dateTime)
    {
        return static::getModifiedDate(static::getDayAfter($dateTime), "midnight");
    }

    /**
     * @param \DateTime $dateA
     * @param \DateTime $dateB
     * @return bool
     */
    public static function isOnSameDay(\DateTime $dateA, \DateTime $dateB)
    {
        return static::getDateAtMidnight($dateA) == static::getDateAtMidnight($dateB); // Häh?! === does not work.
    }
}
