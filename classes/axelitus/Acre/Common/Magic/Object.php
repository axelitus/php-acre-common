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
     **/
    public function __set($property, $value)
    {
        if(property_exists($this, $property)) {
            $method = 'set'.Str::ucfirst($property);
            if(method_exists($this, $method) and is_callable(array($this, $method))) {
                return $this->{$method}($value);
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
     **/
    public function __get($property)
    {
        if(property_exists($this, $property)) {
            $method = 'get'.Str::ucfirst($property);
            if(method_exists($this, $method) and is_callable(array($this, $method)) {
                return $this->{$method}();
            } else {
                throw new RuntimeException("The property '{$property}' is not accesible.");
            }
        } else {
            throw new InvalidArgumentException("The property '{$property}' does not exist.");
        }
    }

}
