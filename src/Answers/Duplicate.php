<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

## In an array with integers between 1 and 1,000,000 one value is in the array twice. How do you determine which one?

/**
 */

echo <<<EOF
If the input is a sorted array that has each of the values between 0 and 1,000,000 then it's possible write an algorithm
to find the duplicated value in O(log n) using the same principal as a binary search, but simply looking to see if the 
binary search value is greater or lass than the expected value, storing the previous value and looking for the specific
spot where the expected and previous didn't match.

Assuming that the array is of variable size and is not sorted then I would do this by writing a for loop that did the
following:
 1. removed values from the original array one at a time
 2. then assigned the value to a new array with the key as the value and the value of true.  If the key was already 
    defined then return the key, which will be the duplicate value

Pseudocode:  

find_duplicate(array) {
    new_array = empty array
    while ( array length > 0 ) {
        value = pop(array)
        if ( new_array has key value ) {
            return value
        }
        new_array[value] = true
    }
    return false
}

Note the return false.  It's not clear what should be returned if no duplicate is found.  This should work for any input
and will have a running time of O(n).

EOF;


/**
 * @param array $array
 * @return int|null
 */
function one_duplicate(array $array): ?int
{
    return null;
}