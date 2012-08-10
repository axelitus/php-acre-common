<?php
/**
 * Part of the axelitus\Acre\Common Package.
 *
 * @package     axelitus\Acre\Common
 * @version     0.1
 * @author      Axel Pardemann (dev@axelitus.mx)
 * @license     pending
 * @copyright   2012 - Axel Pardemann
 * @link        http://axelitus.mx/
 */

namespace axelitus\Acre\Common;

/**
 * Num Class
 *
 * Includes some additional useful features for numbers.
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
class Num
{
    /**
     * Tests if a value is an integer.
     *
     * Tests if a value is an integer. This function will find if the given value is an integer regardless of
     * its variable type (as the is_int function does). Even a string containing an integer value will return true.
     *
     * @param   string  $val    The value to be tested
     * @return  bool    Whether the value is an integer regardless of its variable type
     */
    public static function isInt($val)
    {
        return (is_int($val) or ctype_digit(strval($val)));
    }

    /**
     * Tests if a value is between a two values.
     *
     * Tests if a value is between a two values. The function will correct the limits if inverted. The tested
     * range can be set to have its low and high limits closed (inclusive) or opened (non-inclusive) using the
     * $low_closed and $high_closed parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[ -or- [a,b]).
     *
     * @param   numeric     $val            The number to be tested against the range
     * @param   numeric     $low            The range's low limit
     * @param   numeric     $high           The range's high limit
     * @param   bool        $low_closed     Whether the low limit is closed (inclusive)
     * @param   bool        $high_limit     Whether the high limit is closed (inclusive)
     * @return  bool    Whether the value is between the given range
     */
    public static function between($val, $low, $high, $low_closed = true, $high_closed = true)
    {
        if (!is_numeric($val) or !is_numeric($low) or !is_numeric($high)) {
            throw new InvalidArgumentException("The \$val, \$low and \$high parameters must be numeric.");
        }

        $low_limit = min($low, $high);
        if (!($low_test = ($low_closed)? $low_limit <= $val : $low_limit < $val)) {
            return false;
        }

        $high_limit = max($low, $high);
        if(!($high_test = ($high_closed)? $high_limit >= $val : $high_limit > $val)) {
            return false;
        }

        return true;
    }
}
