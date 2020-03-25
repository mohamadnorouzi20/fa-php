# Farsi PHP
A Collection of Utilities for a Better Experience in Developing Websites with Farsi Content.

## Global Functions

- _`faDigits`_
- _`gregorianToJalali`_
- _`jalaliToGregorian`_
- _`validateJalaliDate`_
- _`validateTime`_

## Date Modification
Since `FaDateTime` is extended from `DateTime` the objects are mutable.
<br>
The `Addition` and `Subtraction` methods are supported but the
modification logic is based on the gregorian calendar.

## Formatting Options
All of the options of the `DateTime` class are supported.

The additional Jalali options are:

- **`jY`** Jalali year (full representation)
- **`jy`** Jalali year (2-digit representation)
- **`jF`** Jalali full month name
- **`jm`** Jalali month with leading zeroes
- **`jn`** Jalali month without leading zeroes
- **`jd`** Jalali day with leading zeroes
- **`jj`** Jalali day without leading zeroes
- **`jl`** Jalali weekday
