<?php
/**
 * Part of the axelitus\Acre\Common Package.
 *
 * @package     axelitus\Acre\Common
 * @version     0.1
 * @author      Axel Pardemann (dev@axelitus.mx)
 * @license     MIT License
 * @copyright   2012 - Axel Pardemann
 * @link        http://axelitus.mx/
 */

namespace axelitus\Acre\Common;

use InvalidArgumentException;

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
     * @static
     * @param   string  $value    The value to be tested
     * @return  bool    Whether the value is an integer regardless of its variable type
     */
    public static function isInt($value)
    {
        return (is_int($value) or ctype_digit(strval($value)));
    }

    /**
     * Tests if a value is between a two values.
     *
     * Tests if a value is between a two values. The function will correct the limits if inverted. The tested
     * range can be set to have its low and high limits closed (inclusive) or opened (non-inclusive) using the
     * $low_closed and $high_closed parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[ -or- [a,b]).
     *
     * @static
     * @param   int|float|double    $value            The number to be tested against the range
     * @param   int|float|double    $low            The range's low limit
     * @param   int|float|double    $high           The range's high limit
     * @param   bool                $low_closed     Whether the low limit is closed (inclusive)
     * @param   bool                $high_closed    Whether the high limit is closed (inclusive)
     * @return  bool    Whether the value is between the given range
     * @throws \InvalidArgumentException
     */
    public static function between($value, $low, $high, $low_closed = true, $high_closed = true)
    {
        if (!is_numeric($value) or !is_numeric($low) or !is_numeric($high)) {
            throw new InvalidArgumentException("The \$value, \$low and \$high parameters must be numeric.");
        }

        $low_limit = min($low, $high);
        if (!($low_test = ($low_closed) ? $low_limit <= $value : $low_limit < $value)) {
            return false;
        }

        $high_limit = max($low, $high);
        if (!($high_test = ($high_closed) ? $high_limit >= $value : $high_limit > $value)) {
            return false;
        }

        return true;
    }
}
