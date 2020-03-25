<?php

use function MN\FaPhp\faDigits;
use function MN\FaPhp\gregorianToJalali;
use function MN\FaPhp\jalaliToGregorian;
use function MN\FaPhp\validateJalaliDate;
use function MN\FaPhp\validateTime;

it('can convert digits to farsi.', function () {
    assertEquals('۰۱۲۳۴۵۶۷۸۹۰۱۲۳۴۵۶۷۸۹', faDigits('01234567890123456789'));
});

it('can convert a gregorian date to jalali.', function () {
    assertEquals([1373, 4, 23], gregorianToJalali(1994, 7, 14));
});

it('can convert a jalali date to gregorian.', function () {
    assertEquals([1994, 7, 14], jalaliToGregorian(1373, 4, 23));
});

it('can validate a jalali date', function () {
    assertTrue(validateJalaliDate(1373, 4, 23));
    assertTrue(validateJalaliDate(1373, 12, 29));
    
    assertFalse(validateJalaliDate(1373, 12, 30)); // not a leap year
    assertTrue(validateJalaliDate(1375, 12, 30)); // a leap year
    
    assertFalse(validateJalaliDate(0, 4, 23));
    assertFalse(validateJalaliDate(1373, 0, 23));
    assertFalse(validateJalaliDate(1373, 4, 0));
});

it('can validate 24 hour format time', function () {
    assertTrue(validateTime(0, 0, 0));
    assertTrue(validateTime(23, 59, 59));
    
    assertFalse(validateTime(0, 0, -1));
    assertFalse(validateTime(0, -1, 0));
    assertFalse(validateTime(-1, 0, 0));
    
    assertFalse(validateTime(24, 0, 0));
});
