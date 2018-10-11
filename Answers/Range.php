<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

## Write a function that checks if an inputted value is a numerical range "100-200".
#  Inputted values can be an integer or a string in the previously stated format.
#  The return should be a true/false (bool) value.
#  Ranges should also allow floats (e.g. "100.00").
#  The range should also be listed as min/max order. Valid values: 100-200, 100.0-200.1. Invalid Values: 100, 200-100.

/**
 * @param string $string
 * @return bool
 */
function is_range(string $string): bool
{
    # explode the string into individual float values
    $ranges = array_map('floatval', explode("-", $string));

    # If there aren't 2 values then it is not a range
    # Or the first value is less than the second value
    if (
        count($ranges) !== 2
        ||
        $ranges[1] < $ranges[0]
    ) {
        return false;
    }

    return true;
}

$checks = [
    '100-200'     => true,
    '100.0-100.1' => true,
    '100-200-300' => false,
    '100.2-100.1' => false,
    '200-100'     => false,
    '100'         => false,
];

foreach ( $checks as $string => $expected ) {
    $result = is_range($string);
    echo sprintf("Checking %s : %s", $string, $result === $expected ? 'good' : 'bad') . PHP_EOL;
}