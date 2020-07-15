<?php

namespace MN\FaPhp;

/**
 *
 *
 * @param  string  $string
 * @return string
 */
function faDigits($string)
{
    return str_replace(
        ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
        $string);
}

/**
 * Based on jdf library v2.70
 *
 * @see https://jdf.scr.ir
 *
 * @param  int  $year
 * @param  int  $month
 * @param  int  $day
 * @return array
 */
function gregorianToJalali($year, $month, $day)
{
    $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    if ($year > 1600) {
        $jy = 979;
        $year -= 1600;
    } else {
        $jy = 0;
        $year -= 621;
    }
    $gy2 = ($month > 2) ? ($year + 1) : $year;
    $days = (365 * $year) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) +
        ((int) (($gy2 + 399) / 400)) - 80 + $day + $g_d_m[$month - 1];
    $jy += 33 * ((int) ($days / 12053));
    $days %= 12053;
    $jy += 4 * ((int) ($days / 1461));
    $days %= 1461;
    $jy += (int) (($days - 1) / 365);
    if ($days > 365) {
        $days = ($days - 1) % 365;
    }
    if ($days < 186) {
        $jm = 1 + (int) ($days / 31);
        $jd = 1 + ($days % 31);
    } else {
        $jm = 7 + (int) (($days - 186) / 30);
        $jd = 1 + (($days - 186) % 30);
    }
    return [$jy, $jm, $jd];
}

/**
 * Based on jdf library v2.70
 *
 * @see https://jdf.scr.ir
 *
 * @param  int  $jYear
 * @param  int  $jMonth
 * @param  int  $jDay
 * @return array
 */
function jalaliToGregorian($jYear, $jMonth, $jDay)
{
    if ($jYear > 979) {
        $gy = 1600;
        $jYear -= 979;
    } else {
        $gy = 621;
    }
    $days = (365 * $jYear) + (((int) ($jYear / 33)) * 8) + ((int) ((($jYear % 33) + 3) / 4))
        + 78 + $jDay + (($jMonth < 7) ? ($jMonth - 1) * 31 : (($jMonth - 7) * 30) + 186);
    $gy += 400 * ((int) ($days / 146097));
    $days %= 146097;
    if ($days > 36524) {
        $gy += 100 * ((int) (--$days / 36524));
        $days %= 36524;
        if ($days >= 365) {
            $days++;
        }
    }
    $gy += 4 * ((int) (($days) / 1461));
    $days %= 1461;
    $gy += (int) (($days - 1) / 365);
    if ($days > 365) {
        $days = ($days - 1) % 365;
    }
    $gd = $days + 1;

    $february_days = ((($gy % 4 == 0) and ($gy % 100 != 0)) or ($gy % 400 == 0)) ? 29 : 28;

    foreach ([0, 31, $february_days, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31] as $gm => $v) {
        if ($gd <= $v) {
            break;
        }
        $gd -= $v;
    }
    return [$gy, $gm, $gd];
}

/**
 * Based on jdf library v2.70
 *
 * @see https://jdf.scr.ir
 *
 * @param  int  $jYear
 * @param  int  $jMonth
 * @param  int  $jDay
 * @return bool
 */
function validateJalaliDate($jYear, $jMonth, $jDay)
{
    $l_d = ($jMonth == 12) ? ((((($jYear % 33) % 4) - 1) == ((int) (($jYear % 33) * 0.05))) ? 30 : 29) : 31 - (int) ($jMonth / 6.5);
    return ($jMonth > 12 or $jDay > $l_d or $jMonth < 1 or $jDay < 1 or $jYear < 1) ? false : true;
}

/**
 *
 *
 * @param  int  $hour
 * @param  int  $minute
 * @param  int  $second
 * @return bool
 */
function validateTime($hour, $minute, $second)
{
    return  !(
        $hour < 0 || $hour > 23 ||
        $minute < 0 || $minute > 59 ||
        $second < 0 || $second > 59
    );
}
