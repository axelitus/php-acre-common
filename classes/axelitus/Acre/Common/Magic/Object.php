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
use RuntimeException;
use axelitus\Acre\Common\Str as Str;

/**
 * Magic_Object Class
 *
 * Base class that allows objects to have "automatic properties".
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
abstract class Magic_Object
{
    /**
     * Sets a value to an existing object's property.
     *
     * @param string    $property   The property to be set
     * @param mixed     $value      The value to set the property to
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     **/
    public function __set($property, $value)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        if ($this->hasProperty($property)) {
            if ($this->hasPropertySetter($property)) {
                return $this->callPropertySetter($property, $value);
            } else {
                throw new RuntimeException("The property '{$property}' is not writeable.");
            }
        } else {
            throw new InvalidArgumentException("The property '{$property}' does not exist.");
        }
    }

    /**
     * Gets the value of an existing object's attribute.
     *
     * @param string    $property   The property to get the value of
     * @return mixed    The value of the property
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     **/
    public function __get($property)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        if ($this->hasProperty($property)) {
            if ($this->hasPropertyGetter($property)) {
                return $this->callPropertyGetter($property);
            } else {
                throw new RuntimeException("The property '{$property}' is not accesible.");
            }
        } else {
            throw new InvalidArgumentException("The property '{$property}' does not exist.");
        }
    }

    /**
     * Determines if the object has the property.
     *
     * @param string    $property   The property to look for
     * @param bool      $strict     Whether the property must match exactly or properties prepended with an underscore
     *                              return a true response too.
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function hasProperty($property, $strict = false)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        if (property_exists($this, $property)) {
            return true;
        }

        if (!$strict and property_exists($this, '_'.$property)) {
            return true;
        }

        return false;
    }

    /**
     * Determines if the object has the method and is callable.
     *
     * @param string    $method     The method to look for
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function hasCallableMethod($method)
    {
        if (!is_string($method) or $method == '') {
            throw new InvalidArgumentException("The \$method parameter must be a non-empty string.");
        }

        return (method_exists($this, $method) and is_callable(array($this, $method)));
    }

    /**
     * Determines if the object has a property setter.
     *
     * @param $property     The property to look for the setter
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function hasPropertySetter($property)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        $method = 'set'.Str::ucfirst($property);
        return $this->hasCallableMethod($method);
    }

    /**
     * Determines if the object has a property getter.
     *
     * @param $property     The property to look for the getter
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function hasPropertyGetter($property)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        $method = 'get'.Str::ucfirst($property);
        return $this->hasCallableMethod($method);
    }

    /**
     * Calls an object method if exists.
     *
     * @param string    $method     The method to be called
     * @param mixed     $args,...   The arguments to call the method
     * @return mixed    The return value for the called method
     * @throws \InvalidArgumentException
     * @throws \RuntimeError
     */
    protected function callMethod($method, $args = null)
    {
        if (!is_string($method) or $method == '') {
            throw new InvalidArgumentException("The \$method parameter must be a non-empty string.");
        }

        // Get all arguments except the method name
        $args = func_get_args();
        array_shift($args);

        if (!$this->hasCallableMethod($method)) {
            throw new RuntimeException("The method {$method} does not exist or is not callable.");
        }

        return call_user_func_array(array($this, $method), $args);
    }

    /**
     * Calls the property setter.
     *
     * @param $property     The property to call the setter method
     * @param $value        The value to call the setter with
     * @return mixed    The property setter return value
     * @throws \InvalidArgumentException
     */
    protected function callPropertySetter($property, $value)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        $method = 'set'.Str::ucfirst($property);
        return $this->callMethod($method, $value);
    }

    /**
     * Calls the property getter.
     *
     * @param $property     The property to call the getter method
     * @return mixed    The property setter return value
     * @throws \InvalidArgumentException
     */
    protected function callPropertyGetter($property)
    {
        if (!is_string($property) or $property == '') {
            throw new InvalidArgumentException("The \$property parameter must be a non-empty string.");
        }

        $method = 'get'.Str::ucfirst($property);
        return $this->callMethod($method);
    }
}
