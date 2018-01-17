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
     * Returns a copy of the given \DateTime object.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getCopyOfDate(\DateTime $dateTime)
    {
        return clone $dateTime;
    }

    /**
     * Returns a copy of $dateTime with the given modification. Does not alter $dateTime.
     *
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
     * Returns a \DateTime object of the day before with the same time.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDayBefore(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "-1 day");
    }

    /**
     * Returns a \DateTime object of the next day with the same time.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDayAfter(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "+1 day");
    }

    /**
     * Returns a \DateTime object with time 00:00:00 and same Date as $dateTime.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getDateAtMidnight(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "midnight");
    }

    /**
     * @deprecated Use getDateAtMidnight instead.
     * Returns a \DateTime object with time 00:00:00 and same Date as $dateTime.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getStartOfDay(\DateTime $dateTime)
    {
        return static::getModifiedDate($dateTime, "midnight");
    }

    /**
     * Returns a \DateTime object of the next day and time 00:00 of $dateTime.
     *
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public static function getEndOfDay(\DateTime $dateTime)
    {
        return static::getModifiedDate(static::getDayAfter($dateTime), "midnight");
    }

    /**
     * Checks if two \DateTime objects have the same Date.
     *
     * @param \DateTime $dateA
     * @param \DateTime $dateB
     * @return bool
     */
    public static function isOnSameDay(\DateTime $dateA, \DateTime $dateB)
    {
        return static::getDateAtMidnight($dateA) == static::getDateAtMidnight($dateB);
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
     * Compares the time of two Dates if the time of $firstDay is later than $secondDay it returns true otherwise false.
     *
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isLaterOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) > $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * Compares the time of two Dates if the time of $firstDay is earlier than $secondDay it returns true otherwise false.
     *
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isEarlierOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) < $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * Compares the time of two Dates if the time of $firstDay ist later or equal than $secondDay it returns true otherwise false.
     *
     * @param \DateTime $firstDay
     * @param \DateTime $secondDay
     * @return bool
     */
    public static function isNotEarlierOnDay(\DateTime $firstDay, \DateTime $secondDay)
    {
        return $firstDay->format(static::DEFAULT_TIME_FORMAT) >= $secondDay->format(static::DEFAULT_TIME_FORMAT);
    }

    /**
     * Compares the time of two Dates if the time of $secondDay ist later or equal than $firstDay it returns true otherwise false.
     *
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
        $interval = $secondDateAtMidnight->diff($firstDateAtMidnight);
        $days = $interval->days;
        if ($firstDateAtMidnight > $secondDateAtMidnight) {
            $days *= -1;
        }
        return $days;
    }

    /**
     * Returns the Difference in seconds between two Dates.
     * Returns a negative value if $startDate is later than $endDate.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInSeconds(\DateTime $startDate, \DateTime $endDate)
    {
        return $endDate->getTimestamp() - $startDate->getTimestamp();
    }

    /**
     * Returns the Difference in full minutes between two Dates. Ignores seconds that don't add up to a full minute.
     * Returns a negative value if $startDate is later than $endDate.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInMinutes(\DateTime $startDate, \DateTime $endDate)
    {
        $interval = $endDate->diff($startDate);
        $minutes = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;
        if ($endDate < $startDate) {
            $minutes *= -1;
        }
        return $minutes;
    }

    /**
     * Returns the Difference ein full hours between two Dates. Ignores minutes and seconds that don't add up to a full hour.
     * Returns a negative value if $startDate is later than $endDate.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInHours(\DateTime $startDate, \DateTime $endDate)
    {
        $interval = $endDate->diff($startDate);
        $hours = $interval->days * 24;
        $hours += $interval->h;
        if ($endDate < $startDate) {
            $hours *= -1;
        }
        return $hours;
    }

    /**
     * Returns the Difference in full days between two Dates. Ignores hours, minutes and seconds that don't add up to a full day.
     * Returns a negative value if $startDate is later than $endDate.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return int
     */
    public static function getDifferenceInDays(\DateTime $startDate, \DateTime $endDate)
    {
        $interval = $endDate->diff($startDate);
        $days = $interval->days;
        if ($endDate < $startDate) {
            $days *= -1;
        }
        return $days;
    }

}
