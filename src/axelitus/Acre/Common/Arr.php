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
use OutOfBoundsException;
use RangeException;
use Closure;
use ReflectionFunction;
use ArrayAccess;
use Countable;
use Iterator;

/**
 * Arr Class
 *
 * Includes some additional useful features for arrays.
 * This class is based on FuelPHP's (http://fuelphp.com) Arr class.
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
class Arr implements ArrayAccess, Iterator, Countable
{
    /**
     * @var  array  Holds the object's data
     */
    protected $_data = array();

    /**
     * Forges a new Arr object.
     *
     * @param   array  $data    The Arr object contents (original array)
     * @return  Arr The new created object
     */
    public static function forge(array $data = array())
    {
        return new static($data);
    }

    /**
     * Constructor
     *
     * @param  array  $data
     */
    public function __construct(array $data = array())
    {
        $this->set(null, $data);
    }

    /**
     * Gets a value from an array or ArrayAccess object according to a dot-notated key.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/kernel)
     * @static
     * @param   string                $key    The dot-notated item key
     * @param   array|ArrayAccess     $input  The array or ArrayAccess object to search the item in
     * @param   mixed                 $return The value of the wanted item
     * @return  bool     Whether we succeeded getting the item
     * @throws  \InvalidArgumentException
     */
    public static function dotGet($key, &$input, &$return)
    {
        if (!is_array($input) and !$input instanceof ArrayAccess) {
            throw new InvalidArgumentException('The second argument of array_get_dot_key() must be an array or ArrayAccess object.');
        }

        // Explode the key and start iterating
        $keys = explode('.', $key);
        while (count($keys) > 0) {
            $key = array_shift($keys);
            if (!isset($input[$key]) or (!empty($keys) and !is_array($input[$key])and !$input[$key] instanceof ArrayAccess)) {
                // Item not found, return failure
                return false;
            }
            $input =& $input[$key];
        }

        // return success
        $return = $input;

        return true;
    }

    /**
     * Sets a value on an array or ArrayAccess object according to a dot-notated key.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/kernel)
     * @static
     * @param   string                $key            The dot-notated item key
     * @param   array|ArrayAccess     $input          The array or ArrayAccess object to search the item in
     * @param   mixed                 $setting        The value to be set
     * @param   bool                  $unsetOnNull    Whether to unset the value if null is given
     * @return  bool     Whether we succeeded setting the item
     * @throws  \InvalidArgumentException
     */
    public static function dotSet($key, &$input, &$setting, $unsetOnNull = false)
    {
        if (!is_array($input) and !$input instanceof ArrayAccess) {
            throw new InvalidArgumentException('The second argument of array_set_dot_key() must be an array or ArrayAccess object.');
        }

        // Explode the key and start iterating
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($input[$key])
                or (!empty($keys) and !is_array($input[$key]) and !$input[$key] instanceof ArrayAccess)
            ) {
                if ($unsetOnNull and is_null($setting)) {
                    // Item not found, impossible to unset, return failure
                    return false;
                }

                // Create new sub-array or overwrite non array
                $input[$key] = array();
            }
            $input =& $input[$key];
        }

        $key = array_shift($keys);
        if ($unsetOnNull and is_null($setting)) {
            if (!isset($input[$key])) {
                // Item not found, impossible to unset, return failure
                return false;
            }

            $setting = $input[$key];
            unset($input[$key]);
        } else {
            $input[$key] = $setting;
        }

        return true;
    }

    /**
     * Checks if a return value is a Closure without params, and if so executes it before returning it.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/kernel)
     * @static
     * @param   mixed     $value    The value to test as a Closure and execute it.
     * @return  mixed    The actual or computed value
     */
    public static function getItemValue($value)
    {
        if ($value instanceof Closure) {
            $refl = new ReflectionFunction($value);
            if ($refl->getNumberOfParameters() === 0) {
                return call_user_func($value);
            }
        }

        return $value;
    }

    /**
     * Gets a dot-notated key from an array, with a default value if it does not exist.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|array      $key        The dot-notated key or array of keys
     * @param   null|mixed        $default    The default value
     * @return  array
     */
    public function get($key, $default = null)
    {
        if (is_null($key)) {
            return $this->_data;
        }

        if (is_array($key)) {
            $return = array();
            foreach ($key as $k) {
                $return[$k] = $this->get($k, $default);
            }

            return $return;
        }

        if (!static::dotGet($key, $this->_data, $return)) {
            return static::getItemValue($default);
        }

        return $return;
    }

    /**
     * Gets the data as an array.
     *
     * @return array The array data.
     */
    public function getArray()
    {
        return $this->_data;
    }

    /**
     * Sets an array item (dot-notated) to the value.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|array      $key    The dot-notated key or array of keys
     * @param   null|mixed        $value  The item's new value
     * @return  Arr    This instance
     */
    public function set($key, $value = null)
    {
        if (is_null($key)) {
            $this->_data = $value;

            return $this;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        }

        static::dotSet($key, $this->_data, $value);

        return $this;
    }

    /**
     * Finds if an item exists in an array with a dot-notated key.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   mixed  $key  The dot-notated key or array of keys
     * @return  bool
     */
    public function keyExists($key)
    {
        return static::dotGet($key, $this->_data, $return);
    }

    /**
     * Replaces key names in an array by names in $replace
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array|string  $replace  key to replace or array containing the replacement keys
     * @param   string        $newKey   the replacement key
     * @return  Arr
     * @throws  \InvalidArgumentException
     */
    public function replaceKey($replace, $newKey = null)
    {
        is_string($replace) and $replace = array($replace => $newKey);
        if (!is_array($replace)) {
            throw new InvalidArgumentException('First parameter must be an array or string.');
        }

        foreach ($this->_data as $key => &$value) {
            if (array_key_exists($key, $replace)) {
                $this->_data[$replace[$key]] = $value;
                unset($this->_data[$key]);
            } else {
                $this->_data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Unsets an item with a dot-notated key from an array.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   mixed   $key  The dot-notated key or array of keys
     * @return  mixed   The deleted value or array of values
     */
    public function delete($key)
    {
        if (is_null($key)) {
            return false;
        }

        if (is_array($key)) {
            $return = array();
            foreach ($key as $k) {
                $return[$k] = $this->delete($k);
            }

            return $return;
        }

        static::dotSet($key, $this->_data, $oldValue, true);

        return $oldValue;
    }

    /**
     * Converts the given 1 dimensional non-associative array to an associative array.
     *
     * The array given must have an even number of elements or an exception will be thrown.
     * The new array will be conformed with the first value as the key and the immediate next
     * value as the item's value.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  array|null  the new array or null
     * @throws  \RangeException
     */
    public function toAssoc()
    {
        if (($count = count($this->_data)) % 2 > 0) {
            throw new RangeException('Number of variables must be even.');
        }
        $keys = $values = array();

        for ($i = 0; $i < $count - 1; $i += 2) {
            $keys[] = array_shift($arr);
            $values[] = array_shift($arr);
        }

        return array_combine($keys, $values);
    }

    /**
     * Checks if the given array is an assoc array.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  bool   true if its an assoc array, false if not
     */
    public function isAssoc()
    {
        foreach ($this->_data as $key => $unused) {
            if (!is_int($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Filters an array on prefixed associative keys.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string  $prefix        prefix to filter on
     * @param   bool    $removePrefix  whether to remove the prefix
     * @return  array
     */
    public function filterPrefixed($prefix = 'prefix_', $removePrefix = true)
    {
        $return = array();
        foreach ($this->_data as $key => &$value) {
            if (preg_match('/^'.$prefix.'/', $key)) {
                if ($removePrefix === true) {
                    $key = preg_replace('/^'.$prefix.'/', '', $key);
                }
                $return[$key] = $value;
            }
        }

        return $return;
    }

    /**
     * Filters an array by an array of keys
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array  $keys     the keys to filter
     * @param   bool   $remove   if true, removes the matched elements.
     * @return  array
     */
    public function filterKeys($keys, $remove = false)
    {
        $return = array();
        foreach ($keys as $key) {
            if (isset($this->_data[$key])) {
                $return[$key] = $this->_data[$key];
                if ($remove) {
                    unset($this->_data[$key]);
                }
            }
        }

        return $return;
    }

    /**
     * Insert value(s) into an array, mostly an array_splice alias
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array|mixed  $value  the value(s) to insert, arrays needs to be inside an array themselves
     * @param   int          $pos    the numeric position at which to insert, negative to count from the end backward
     * @return  Arr
     * @throws  \OutOfBoundsException
     */
    public function insert($value, $pos)
    {
        if (count($this->_data) < abs($pos)) {
            throw new OutOfBoundsException('Position larger than number of elements in array in which to insert.');
        }
        array_splice($original, $pos, 0, $value);

        return $this;
    }

    /**
     * Insert value(s) into an array before a specific key
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array|mixed  $value  the value(s) to insert, arrays need to be inside an array themselves
     * @param   string|int   $key    the key before which to insert
     * @return  Arr
     * @throws  \OutOfBoundsException
     */
    public function insertBeforeKey($value, $key)
    {
        $pos = array_search($key, array_keys($this->_data));
        if ($pos === false) {
            throw new OutOfBoundsException('Unknown key before which to insert the new value into the array.');
        }

        return $this->insert($value, $pos);
    }

    /**
     * Insert value(s) into an array after a specific key
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array|mixed  $value  the value(s) to insert, arrays need to be inside an array themselves
     * @param   string|int   $key    the key after which to insert
     * @return  Arr
     * @throws  \OutOfBoundsException
     */
    public function insertAfterKey($value, $key)
    {
        $pos = array_search($key, array_keys($this->_data));
        if ($pos === false) {
            throw new OutOfBoundsException('Unknown key after which to insert the new value into the array.');
        }

        return $this->insert($value, $pos + 1);
    }

    /**
     * Insert value(s) into an array after a specific value (first found in array)
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array|mixed  $value   the value(s) to insert, arrays need to be inside an array themselves
     * @param   string|int   $search  the value after which to insert
     * @return  Arr
     * @throws  \OutOfBoundsException
     */
    public function insertAfterValue($value, $search)
    {
        $key = array_search($search, $this->_data);
        if ($key === false) {
            throw new OutOfBoundsException('Unknown value after which to insert the new value into the array.');
        }

        return $this->insertAfterKey($value, $key);
    }

    /**
     * Flattens a multi-dimensional associative array down into a 1 dimensional associative array.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string  $glue     What to glue the keys together with
     * @param   bool    $indexed  Whether to flatten only associative array's, or also indexed ones
     * @return  array
     */
    public function flatten($glue = '.', $indexed = true)
    {
        $return = array();
        $currKey = array();
        $flatten = function (&$array, &$currKey, &$return, $glue, $indexed, $self) {
            foreach ($array as $key => &$value) {
                $curr_key[] = $key;
                if ((is_array($value) or $value instanceof Iterator)
                    and ($indexed or array_values($value) !== $value)
                ) {
                    $self($value, $currKey, $return, $glue, false);
                } else {
                    $return[implode($glue, $currKey)] = $value;
                }

                array_pop($currKey);
            }
        };

        return $flatten($this->_data, $currKey, $return, $glue, $indexed, $flatten);
    }

    /**
     * Flattens a multi-dimensional associative array down into a 1 dimensional associative array.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string  $glue   what to glue the keys together with
     * @return  array
     */
    public function flattenAssoc($glue = '.')
    {
        return $this->flatten($glue, false);
    }

    /**
     * Merge 2 or more arrays recursively, differs in 2 important ways from array_merge_recursive()
     * - When there's 2 different values and not both arrays, the latter value overwrites the earlier
     *   instead of merging both into an array
     * - Numeric keys that don't conflict aren't changed, only when a numeric key already exists is the
     *   value added using array_push()
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   array  $array,...   multiple variables all of which must be arrays
     * @return  Arr
     * @throws  \InvalidArgumentException
     */
    public function merge($array)
    {
        $merge = function (&$array1, $array2, $self) {
            foreach ($array2 as $k => &$v) {
                // numeric keys are appended
                if (is_int($k)) {
                    array_key_exists($k, $array1) ? array_push($array1, $v) : $array1[$k] = $v;
                } elseif (is_array($v) and array_key_exists($k, $array1) and is_array($array1[$k])) {
                    $array1[$k] = $self($array1[$k], $v);
                } else {
                    $array1[$k] = $v;
                }
            }

            return $array1;
        };

        $arrays = func_get_args();
        foreach ($arrays as &$arr) {
            if (!is_array($arr)) {
                throw new InvalidArgumentException('Arr::merge() - all arguments must be arrays.');
            }

            $this->_data = $merge($this->_data, $arr, $merge);
        }

        return $this;
    }

    /**
     * Prepends a value with an associative key to an array.
     * Will overwrite if the value exists.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|array  $key    the key or array of keys and values
     * @param   mixed         $value  the value to prepend
     * @return  Arr
     */
    public function prepend($key, $value = null)
    {
        $this->_data = (is_array($key) ? $key : array($key => $value)) + $this->_data;

        return $this;
    }

    //<editor-fold desc="Countable Interface">
    /**
     * Implements Countable interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  int
     */
    public function count()
    {
        return count($this->_data);
    }

    //</editor-fold>

    //<editor-fold desc="ArrayAccess Interface">
    /**
     * Implements ArrayAccess Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|int  $offset
     * @return  bool
     */
    public function offsetExists($offset)
    {
        return $this->keyExists($offset);
    }

    /**
     * Implements ArrayAccess Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|int  $offset
     * @return  mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Implements ArrayAccess Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|int  $offset
     * @param   mixed       $value
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Implements ArrayAccess Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @param   string|int  $offset
     * @return  void
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    //</editor-fold>

    //<editor-fold desc="Iterator Interface">
    /**
     * Implements Iterator Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  mixed
     */
    public function current()
    {
        return current($this->_data);
    }

    /**
     * Implements Iterator Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  mixed
     */
    public function key()
    {
        return key($this->_data);
    }

    /**
     * Implements Iterator Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  void
     */
    public function next()
    {
        next($this->_data);
    }

    /**
     * Implements Iterator Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  mixed
     */
    public function rewind()
    {
        return reset($this->_data);
    }

    /**
     * Implements Iterator Interface
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @see     FuelPHP Kernel Package (http://packagist.org/packages/fuel/core)
     * @return  bool
     */
    public function valid()
    {
        return !is_null($this->key());
    }
    //</editor-fold>
}
