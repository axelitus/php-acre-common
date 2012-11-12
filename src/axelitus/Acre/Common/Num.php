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
    const RANGE_NON_INCLUSIVE = 'non_inclusive';

    const RANGE_LOW_INCLUSIVE = 'low_inclusive';

    const RANGE_HIGH_INCLUSIVE = 'high_inclusive';

    const RANGE_BOTH_INCLUSIVE = 'both_inclusive';

    /**
     * Tests if a value is an integer.
     *
     * Tests if a value is an integer. This function will find if the given value is an integer regardless of
     * its variable type (as the is_int function does). Even a string containing an integer value will return true.
     *
     * @static
     * @param   mixed   $value    The value to be tested
     * @return  bool    Whether the value is an integer regardless of its variable type
     */
    public static function isInt($value)
    {
        return (is_int($value) or ctype_digit(strval($value)));
    }

    /**
     * Gets the given textual range definition expressed as a boolean array
     *
     * @static
     * @param string    $range_def  The textual range definition (one of the RANGE_* constants)
     * @return array    The range definition expressed as a boolean array
     */
    private static function getRangeBehaviour($range_def)
    {
        switch ($range_def) {
            case self::RANGE_NON_INCLUSIVE:
                $range_behave = array('low' => false, 'high' => false);
                break;
            case self::RANGE_LOW_INCLUSIVE:
                $range_behave = array('low' => true, 'high' => false);
                break;
            case self::RANGE_HIGH_INCLUSIVE:
                $range_behave = array('low' => false, 'high' => true);
                break;
            case self::RANGE_BOTH_INCLUSIVE:
            default:
                $range_behave = array('low' => true, 'high' => true);
        }

        return $range_behave;
    }

    /**
     * Tests if a value is between a two values.
     *
     * Tests if a value is between a two values. The function will correct the limits if inverted. The tested
     * range can be set to have its low and high limits closed (inclusive) or opened (non-inclusive) using the
     * $low_closed and $high_closed parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[ -or- [a,b]).
     *
     * @static
     * @param   int|float    $value          The number to be tested against the range
     * @param   int|float    $low            The range's low limit
     * @param   int|float    $high           The range's high limit
     * @param   string       $range_def      The definition of the range type: non-inclusive, low-inclusive, high-inclusive, both-inclusive
     * @return  bool    Whether the value is between the given range
     * @throws \InvalidArgumentException
     */
    public static function between($value, $low, $high, $range_def = self::RANGE_BOTH_INCLUSIVE)
    {
        if (!is_numeric($value) or !is_numeric($low) or !is_numeric($high)) {
            throw new InvalidArgumentException("The \$value, \$low and \$high parameters must be numeric.");
        }

        $range_behave = self::getRangeBehaviour($range_def);

        $low_lim = min($low, $high);
        if (!($low_test = ($range_behave['low']) ? $low_lim <= $value : $low_lim < $value)) {
            return false;
        }

        $high_lim = max($low, $high);
        if (!($high_test = ($range_behave['high']) ? $high_lim >= $value : $high_lim > $value)) {
            return false;
        }

        return true;
    }

    /**
     * Returns a random integer using the defined range.
     *
     * @static
     * @param   int     $high          The range's upper limit (high value)
     * @param   int     $low           The range's lower limit (low value)
     * @param   string  $range_def     The type of range it is (accepted values: one of the class constants RANGE_*)
     * @return  int     The generated random int as specified by the range
     * @throws  InvalidArgumentException
     */
    public static function randomInt($high, $low = 0, $range_def = self::RANGE_BOTH_INCLUSIVE)
    {
        if (!self::isInt($high) || !self::isInt($low)) {
            throw new InvalidArgumentException("The \$high and \$low parameters must be integers.");
        }

        $range_behave = self::getRangeBehaviour($range_def);

        if ($low == $high) {
            if (!($range_behave['low'] and $range_behave['high'])) {
                throw new InvalidArgumentException("Defining a non-inclusive range with both high and low limits set to the same value is invalid.");
            } else {
                return $high;
            }
        }

        $low_lim = min($low, $high) + (($range_behave['low']) ? 0 : 1);
        $high_lim = max($low, $high) - (($range_behave['high']) ? 0 : 1);

        if ($low_lim > $high_lim) {
            throw new InvalidArgumentException("Defining a non-inclusive range must have a separation of at least two between limits.");
        }

        return mt_rand($low_lim, $high_lim);
    }
}
