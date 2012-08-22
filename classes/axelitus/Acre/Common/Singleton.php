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
 * Singleton Class
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
abstract class Singleton
{
    /**
     * @var string  The singleton's initialization method (declaration if optional)
     **/
    const INIT_METHOD = 'init';

    /**
     * @var mixed   The singleton instance when forged
     **/
    protected static $_instance = null;

    /**
     * Prevent this class from being instantiated (but allow sub-classes to create new instances).
     */
    final protected function __construct()
    {
    }

    /**
     * Forges a new instance of the singleton.
     *
     * Forges a new instance of the singleton. If an instance already exists it will be returned. Alias to Singleton::instance().
     * The parameters are passed along to the init method if present to autoinitialize (configure) the singleton.
     *
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function forge()
    {
        return call_user_func_array(get_called_class().'::instance', func_get_args());
    }

    /**
     * Forges a new instance of the singleton.
     *
     * Forges a new instance of the singleton. If an instance already exists it will be removed and a new one will be created in it's place.
     * The parameters are passed along to the init method if present to autoinitialize (configure) the singleton.
     *
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function forgeReplace()
    {
        static::removeInstance();
        return call_user_func_array(get_called_class().'::instance', func_get_args());
    }

    /**
     * Forges a new instance of the singleton or returns the existing one.
     *
     * Forges a new instance of the singleton or returns the existing one. The parameters are passed along to the init method if present
     * to autoinitialize (configure) the singleton.
     *
     * @param mixed     $params     The singleton's init parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function instance()
    {
        if(static::$_instance == null or !static::$_instance instanceof static) {
            static::$_instance = new static();
            if(method_exists(static::$_instance, static::INIT_METHOD) and is_callable(array(static::$_instance, static::INIT_METHOD))) {
                call_user_func_array(array(static::$_instance, static::INIT_METHOD), func_get_args());
            }
        }

        return static::$_instance;
    }

    /**
     * Removes the singleton's instance.
     */
    public static function removeInstance()
    {
        static::$_instance = null;
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
