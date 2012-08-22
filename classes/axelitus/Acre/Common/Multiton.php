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

/**
 * Multiton Class
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
abstract class Multiton
{
    /**
     * @var string  The singleton's initialization method (declaration if optional)
     **/
    const INIT_METHOD = 'init';

     /**
     * @static
     * @var mixed   The singleton's instances array
     **/
    protected static $_instances = array();

     /**
     * Prevent this class from being instantiated (but allow sub-classes to create new instances).
     */
    final protected function __construct()
    {
    }

    /**
     * Forges a new singleton instance and stores it using the key as identifier.
     *
     * Forges a new singleton instance and stores it using the key as identifier. If an instance with the key already exists
     * it will be returned. Alias to Multiton::instance().
     * The parameters are passed along to the init method if present to autoinitialize (configure) the singleton.
     * ALL params are passed, the first one being the key of the instance.
     *
     * @static
     * @param string    $key        The singleton's key (name)
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function forge($key)
    {
        return call_user_func_array(get_called_class().'::instance', func_get_args());
    }

    /**
     * Forges a new singleton instance and stores it using the key as identifier.
     *
     * Forges a new singleton instance and stores it using the key as identifier. If an instance already exists it will be removed
     * and a new one will be created in it's place.
     * The parameters are passed along to the init method if present to autoinitialize (configure) the singleton.
     * ALL params are passed, the first one being the key of the instance.
     *
     * @static
     * @param string    $key        The singleton's key (name)
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function forgeReplace($key)
    {
        static::removeInstance($key);
        return call_user_func_array(get_called_class().'::instance', func_get_args());
    }

    /**
     * Forges a new instance of a singleton or returns the existing one by key.
     *
     * Forges a new instance of a singleton or returns the existing one by key. The singletons are keyed (named) to identify them.
     * The parameters are passed along to the init method if present to autoinitialize (configure) the singleton.
     * ALL params are passed, the first one being the name of the instance.
     *
     * @static
     * @param string    $key        The singleton's key (name)
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function instance($key)
    {
        if(empty(static::$_instances) or !isset(static::$_instances[$key]) or !static::$_instances[$key] instanceof static) {
            static::$_instances[$key] = new static();
            if(method_exists(static::$_instances[$key], static::INIT_METHOD) and is_callable(array(static::$_instances[$key], static::INIT_METHOD))) {
                call_user_func_array(array(static::$_instances[$key], static::INIT_METHOD), func_get_args());
            }
        }

        return static::$_instances[$key];
    }

    /**
     * Removes a singleton instance.
     *
     * @param string    $key    The key of the singleton to remove
     * @static
     */
    public static function removeInstance($key)
    {
        static::$_instances[$key] = null;
        unset(static::$_instances[$key]);
    }

    /**
     * Clears the multiton's instances array.
     */
    public static function clearInstances()
    {
        static::$_instances = array();
    }

    /**
     * No serialization allowed
     */
    final public function __sleep()
    {
        trigger_error("No serialization allowed!", E_USER_ERROR);
    }

    /**
     * No cloning allowed
     */
    final public function __clone()
    {
        trigger_error("No cloning allowed!", E_USER_ERROR);
    }

}
