<?php

use MN\FaPhp\FaDateTime;
use function MN\FaPhp\faDigits;

it('can be created.', function () {
    $faDateTime = new FaDateTime();

    assertInstanceOf(FaDateTime::class, $faDateTime);
});


it('can instantiate an object with current datetime data.', function () {
    assertInstanceOf(FaDateTime::class, FaDateTime::now());
});


it('returns correct data for datetime accessors.', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 23);

    assertEquals('1373', $faDateTime->jYear());
    assertEquals('4', $faDateTime->jMonth());
    assertEquals('23', $faDateTime->jDay());
});


it('can be formatted.', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 5, 12, 8, 5);

    assertEquals('1373/04/05 12:08:05', $faDateTime->format('jY/jm/jd H:i:s'));
    assertEquals('73/4/5 12:08:05', $faDateTime->format('jy/jn/jj H:i:s'));
});


it('can format the weekdays.', function () {
    $faDateTime1 = FaDateTime::createFromJalali(1373, 4, 4);
    $faDateTime2 = FaDateTime::createFromJalali(1373, 4, 5);
    $faDateTime3 = FaDateTime::createFromJalali(1373, 4, 6);
    $faDateTime4 = FaDateTime::createFromJalali(1373, 4, 7);
    $faDateTime5 = FaDateTime::createFromJalali(1373, 4, 8);
    $faDateTime6 = FaDateTime::createFromJalali(1373, 4, 9);
    $faDateTime7 = FaDateTime::createFromJalali(1373, 4, 10);

    assertEquals('شنبه', $faDateTime1->format('jl'));
    assertEquals('یک شنبه', $faDateTime2->format('jl'));
    assertEquals('دو شنبه', $faDateTime3->format('jl'));
    assertEquals('سه شنبه', $faDateTime4->format('jl'));
    assertEquals('چهار شنبه', $faDateTime5->format('jl'));
    assertEquals('پنج شنبه', $faDateTime6->format('jl'));
    assertEquals('جمعه', $faDateTime7->format('jl'));
});


it('can format the month names.', function () {
    $faDateTime1 = FaDateTime::createFromJalali(1373, 1, 1);
    $faDateTime2 = FaDateTime::createFromJalali(1373, 2, 1);
    $faDateTime3 = FaDateTime::createFromJalali(1373, 3, 1);
    $faDateTime4 = FaDateTime::createFromJalali(1373, 4, 1);
    $faDateTime5 = FaDateTime::createFromJalali(1373, 5, 1);
    $faDateTime6 = FaDateTime::createFromJalali(1373, 6, 1);
    $faDateTime7 = FaDateTime::createFromJalali(1373, 7, 1);
    $faDateTime8 = FaDateTime::createFromJalali(1373, 8, 1);
    $faDateTime9 = FaDateTime::createFromJalali(1373, 9, 1);
    $faDateTime10 = FaDateTime::createFromJalali(1373, 10, 1);
    $faDateTime11 = FaDateTime::createFromJalali(1373, 11, 1);
    $faDateTime12 = FaDateTime::createFromJalali(1373, 12, 1);

    assertEquals('فروردین', $faDateTime1->format('jF'));
    assertEquals('اردیبهشت', $faDateTime2->format('jF'));
    assertEquals('خرداد', $faDateTime3->format('jF'));
    assertEquals('تیر', $faDateTime4->format('jF'));
    assertEquals('مرداد', $faDateTime5->format('jF'));
    assertEquals('شهریور', $faDateTime6->format('jF'));
    assertEquals('مهر', $faDateTime7->format('jF'));
    assertEquals('آبان', $faDateTime8->format('jF'));
    assertEquals('آذر', $faDateTime9->format('jF'));
    assertEquals('دی', $faDateTime10->format('jF'));
    assertEquals('بهمن', $faDateTime11->format('jF'));
    assertEquals('اسفند', $faDateTime12->format('jF'));
});


it('can add an interval to the date', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 23, 12, 8, 35);

    $faDateTime->add(new DateInterval('P6Y4MT3M')); // 6 years and 4 months and 3 minutes

    assertEquals('1379/8/24 12:11:35', (string) $faDateTime);
});


it('can subtract an interval from the date', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 23, 12, 8, 35);

    $faDateTime->sub(new DateInterval('P0Y7MT10S')); // 0 years and 7 months and 10 seconds

    assertEquals('1372/9/23 12:08:25', (string) $faDateTime);
});


it('can be formatted with farsi digits.', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 23, 12, 8, 35);

    assertEquals(faDigits('1373/04/23 12:08:35'), $faDateTime->format('jY/jm/jd H:i:s', true));
});


it('can be converted to a string.', function () {
    $faDateTime = FaDateTime::createFromJalali(1373, 4, 23, 12, 8, 35);

    assertEquals('1373/4/23 12:08:35', (string) $faDateTime);
});
