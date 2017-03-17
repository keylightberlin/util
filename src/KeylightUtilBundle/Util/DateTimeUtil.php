<?php
namespace KeylightUtilBundle\Util;

/**
 * A class for easily duplicating and comparing dates. Never alters the date passed to the function.
 */
final class DateTimeUtil
{
    const DEFAULT_DATE_FORMAT = "Y-m-d";
    const DEFAULT_TIME_FORMAT = "H:i";

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

    /**
     * Return the \DateTime object of that day and time. Time is given as H:i
     * Not very elegant.
     *
     * @param \DateTime $day
     * @param string $time
     * @return \DateTime
     */
    public static function getDateTimeForDayAndTime(\DateTime $day, $time)
    {
        return \DateTime::createFromFormat(
            static::DEFAULT_DATE_FORMAT . " " . static::DEFAULT_TIME_FORMAT,
            $day->format(static::DEFAULT_DATE_FORMAT) . " " . $time
        );
    }

    /**
     * Checks that the time is equal, regardless of the day. Only considers time up to minutes.
     *
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isTimeEqual(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) === $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isLaterOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) > $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isEarlierOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) < $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isNotEarlierOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) >= $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isNotLaterOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) <= $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * Returns the number of days that lie between firstDate and secondDate, on a day basis. That means that
     * in particular that DateTime objects that are on the same day have difference 0.
     *
     * If firstDate is bigger than secondDate, this number will be negative.
     *
     * @param \DateTime $firstDate
     * @param \DateTime $secondDate
     * @return int
     */
    public static function getDifferenceInNumberOfDays(\DateTime $firstDate, \DateTime $secondDate)
    {
        $firstDateAtMidnight = static::getDateAtMidnight($firstDate);
        $secondDateAtMidnight = static::getDateAtMidnight($secondDate);
        return $firstDateAtMidnight->diff($secondDateAtMidnight)->d;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInSeconds(\DateTime $startDate, \DateTime $endDate)
    {
        return ($endDate->getTimestamp() - $startDate->getTimestamp());
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInMinutes(\DateTime $startDate, \DateTime $endDate)
    {
        return floor(static::getDifferenceInSeconds($startDate, $endDate) / 60);
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInHours(\DateTime $startDate, \DateTime $endDate)
    {
        return floor(static::getDifferenceInSeconds($startDate, $endDate) / (60 * 60));
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInDays(\DateTime $startDate, \DateTime $endDate)
    {
        $interval = $endDate->diff($startDate);
        return intval($interval->format('%a'));
    }

}
