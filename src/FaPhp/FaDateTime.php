<?php

namespace MN\FaPhp;

use DateTime;
use DateTimeZone;
use Exception;

/**
 *
 */
class FaDateTime extends DateTime
{
    const JALALI_WEEK_DAYS = [
        'شنبه',
        'یک شنبه',
        'دو شنبه',
        'سه شنبه',
        'چهار شنبه',
        'پنج شنبه',
        'جمعه'
    ];

    const JALALI_MONTHS = [
        'فروردین',
        'اردیبهشت',
        'خرداد',
        'تیر',
        'مرداد',
        'شهریور',
        'مهر',
        'آبان',
        'آذر',
        'دی',
        'بهمن',
        'اسفند'
    ];

    /** @var int */
    protected $jYear, $jMonth, $jDay;

    /**
     *
     * @param string $time
     * @param DateTimeZone $timezone
     */
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    /**
     *
     * @return int
     */
    public function jYear()
    {
        return $this->jYear;
    }

    /**
     *
     * @return int
     */
    public function jMonth()
    {
        return $this->jMonth;
    }

    /**
     *
     * @return string
     */
    public function jMonthName()
    {
        return self::JALALI_MONTHS[$this->jMonth - 1];
    }

    /**
     *
     * @return int
     */
    public function jDay()
    {
        return $this->jDay;
    }

    /**
     *
     * @return string
     */
    public function jWeekday()
    {
        switch (date_format($this, 'l')) {
            case 'Saturday':
                return self::JALALI_WEEK_DAYS[0];
            case 'Sunday':
                return self::JALALI_WEEK_DAYS[1];
            case 'Monday':
                return self::JALALI_WEEK_DAYS[2];
            case 'Tuesday':
                return self::JALALI_WEEK_DAYS[3];
            case 'Wednesday':
                return self::JALALI_WEEK_DAYS[4];
            case 'Thursday':
                return self::JALALI_WEEK_DAYS[5];
            case 'Friday':
                return self::JALALI_WEEK_DAYS[6];
        }

        return null; // Should never happen
    }

    /**
     *
     * @param DateTimeZone $timezone
     * @return FaDateTime
     */
    public static function now(DateTimeZone $timezone = null)
    {
        return static::createFromDateTime(new DateTime('now', $timezone));
    }

    /**
     *
     * @param DateTime $dateTime
     * @return FaDateTime
     */
    public static function createFromDateTime(DateTime $dateTime)
    {
        list($year, $month, $day, $hour, $minute, $second) = array_map(
            function ($dateTimePart) {
                return (int)$dateTimePart;
            },
            explode('-', $dateTime->format('Y-n-j-H-i-s'))
        );

        list($jYear, $jMonth, $jDay) = gregorianToJalali($year, $month, $day);

        return static::createFromJalali($jYear, $jMonth, $jDay, $hour, $minute, $second, $dateTime->getTimezone());
    }

    /**
     *
     * @param int $jYear
     * @param int $jMonth
     * @param int $jDay
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $timezone
     * @return FaDateTime
     */
    public static function createFromJalali(
        $jYear,
        $jMonth,
        $jDay,
        $hour = 0,
        $minute = 0,
        $second = 0,
        DateTimeZone $timezone = null
    ) {
        if (!validateJalaliDate($jYear, $jMonth, $jDay)) {
            throw new Exception('Invalid Jalali date!');
        }

        $gregorian = implode(
            ' ',
            [
                implode('-', jalaliToGregorian($jYear, $jMonth, $jDay)),
                implode(':', [$hour, $minute, $second]),
            ]
        );

        $faDateTime = new static($gregorian, $timezone);
        $faDateTime->jYear = $jYear;
        $faDateTime->jMonth = $jMonth;
        $faDateTime->jDay = $jDay;

        return $faDateTime;
    }

    /**
     * @inheritDoc
     */
    public function add($interval)
    {
        parent::add($interval);

        list($year, $month, $day) = array_map(
            function ($dateTimePart) {
                return (int)$dateTimePart;
            },
            explode('-', $this->format('Y-n-j'))
        );

        list($this->jYear, $this->jMonth, $this->jDay) = gregorianToJalali($year, $month, $day);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function sub($interval)
    {
        parent::sub($interval);

        list($year, $month, $day) = array_map(
            function ($dateTimePart) {
                return (int)$dateTimePart;
            },
            explode('-', $this->format('Y-n-j'))
        );

        list($this->jYear, $this->jMonth, $this->jDay) = gregorianToJalali($year, $month, $day);

        return $this;
    }

    /**
     *
     * @param string $format
     * @param bool $faDigits
     * @return string
     */
    public function format($format, $faDigits = false)
    {
        $formattedWithJalali = str_replace(
            ['jy', 'jY', 'jF', 'jm', 'jn', 'jd', 'jj', 'jl'],
            [
                sprintf('%02d', $this->jYear % 100),
                $this->jYear,
                $this->jMonthName(),
                sprintf('%02d', $this->jMonth),
                $this->jMonth,
                sprintf('%02d', $this->jDay),
                $this->jDay,
                $this->jWeekday(),
            ],
            $format
        );

        $formattedString = date_format($this, $formattedWithJalali);

        return $faDigits ? faDigits($formattedString) : $formattedString;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('jY/jn/jj H:i:s');
    }
}
