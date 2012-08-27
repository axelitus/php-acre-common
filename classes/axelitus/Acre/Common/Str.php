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
 * Str Class
 *
 * Includes some additional useful features for strings.
 *
 * @package     axelitus\Acre\Common
 * @category    Common
 * @author      Axel Pardemann (dev@axelitus.mx)
 */
class Str
{
    /**
     * @var string  A string containing all alpha characters
     */
    const ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @var string  A string containing all numbers
     */
    const NUM = '0123456789';

    /**
     * @var string  A string containing all alphanumeric characters
     */
    const ALNUM = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @var string  A string containing all hexadecimal characters
     */
    const HEXDEC = '0123456789abcdef';

    /**
     * @var string  A string containing distinct characters
     */
    const DISTINCT = '2345679ACDEFHJKLMNPRSTUVWXYZ';

    /**
     * @var string  A string containing ascii printable characters according to Wikipedia:
     * http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
     * Be careful, the ' char is escaped so it looks like \ is twice, but it is not.
     */
    const ASCII_PRINTABLE = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';

    /**
     * @var string  The default encoding to use with some functions.
     */
    const DEFAULT_ENCODING = 'UTF-8';

    /**
     * Returns the length of a string.
     *
     * Returns the length of a string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The function uses mb_strlen if present and falls back to strlen.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  int     The length of the input string
     */
    public static function length($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strlen')
            ? mb_strlen($input, $encoding)
            : strlen($input);
    }

    /**
     * Returns a substring from the given string.
     *
     * Returns a substring from the given string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The function uses mb_substr if present and falls back to substr.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string    $input        The input string
     * @param   int       $start        The start index from where to begin extracting
     * @param   int|null  $length       The length of the extracted substring
     * @param   string    $encoding     The encoding of the input string
     * @return  string
     */
    public static function sub($input, $start, $length = null, $encoding = self::DEFAULT_ENCODING)
    {
        // subinput functions don't parse null correctly
        $length = is_null($length)
            ? (function_exists('mb_substr')
                ? mb_strlen($input, $encoding)
                : strlen($input)) - $start
            : $length;

        return function_exists('mb_substr')
            ? mb_substr($input, $start, $length, $encoding)
            : substr($input, $start, $length);
    }

    /**
     * Returns a lowercased string.
     *
     * Returns a lowercased string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The functions uses mb_strtolower if present and falls back to strtolower.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  string  The lowercased string
     */
    public static function lower($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtolower')
            ? mb_strtolower($input, $encoding)
            : strtolower($input);
    }

    /**
     * Returns an uppercased string.
     *
     * Returns an uppercased string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The functions uses mb_strtoupper if present and falls back to strtoupper.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  string  The uppercased string
     */
    public static function upper($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtoupper')
            ? mb_strtoupper($input, $encoding)
            : strtoupper($input);
    }

    /**
     * Returns a string with the first char as lowercase.
     *
     * Returns a string with the first char as lowercase. The other characters in the string are left untouched.
     * The $encoding parameter is used to determine the input string encoding and thus use the proper method.
     * The function uses mb_strtolower, mb_mb_substr and mb_strlen if present and falls back to lcfirst.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  string  The string with the first char lowercased
     */
    public static function lcfirst($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtolower')
            ? mb_strtolower(mb_substr($input, 0, 1, $encoding), $encoding).
                mb_substr($input, 1, mb_strlen($input, $encoding), $encoding)
            : lcfirst($input);
    }

    /**
     * Returns a string with the first char as uppercase.
     *
     * Returns a string with the first char as uppercase. The other characters in the string are left untouched.
     * The $encoding parameter is used to determine the input string encoding and thus use the proper method.
     * The function uses mb_strtoupper, mb_mb_substr and mb_strlen if present and falls back to ucfirst.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  string  The string with the first char uppercased
     */
    public static function ucfirst($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtoupper')
            ? mb_strtoupper(mb_substr($input, 0, 1, $encoding), $encoding).
                mb_substr($input, 1, mb_strlen($input, $encoding), $encoding)
            : ucfirst($input);
    }

    /**
     * Returns a string with the words capitalized.
     *
     * Returns a string with the words capitalized. The $encoding parameter is used to determine the input string
     * encoding and thus use the proper method. The function uses mb_convert_case if present and falls back to ucwords.     *
     * The ucwords function normally does not lowercase the input string first, this function does.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param   string  $input      The input string
     * @param   string  $encoding   The encoding of the input string
     * @return  string  The string with the words capitalized
     */
    public static function ucwords($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_convert_case')
            ? mb_convert_case($input, MB_CASE_TITLE, $encoding)
            : ucwords(strtolower($input));
    }

    /**
     * Returns a random string from the given input string.
     *
     * Returns a random string from the given input string. The characters can be shuffled to increase the
     * randomness (entropy) of the function. The $chars parameter must be a string with at least one character.
     * The length of the returned string can be controlled with the $length parameter, but every characters is
     * randomized independently with each loop.
     *
     * @param   int     $length     The length of the output string
     * @param   string  $chars      The pool of characters to randomize from
     * @param   bool    $shuffle    Whether to shuffle the character string to increase randomness (entropy)
     * @return  string  The random string containing random characters from the $chars string
     * @throws  \InvalidArgumentException
     */
    public static function random($length = 1, $chars = self::ALNUM, $shuffle = false)
    {
        if (!is_string($chars) or $chars == '') {
            throw new InvalidArgumentException("The \$chars parameter must be a non-empty string containing a set of characters to pick a random value from.");
        }

        if (!is_numeric($length) or $length < 0) {
            throw new InvalidArgumentException("The \$length parameter must be a positive integer or zero.");
        }

        $chars = ($shuffle) ? str_shuffle($chars) : $chars;

        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, static::length($chars) - 1)];
        }

        return $string;
    }

    /**
     * Returns a type-random string.
     *
     * Returns a type-random string. The $type parameter defines the pool of characters to randomize from. The pool
     * can be shuffled to increase the randomness (entropy) of the function. The length of the returned string can be
     * controlled with the $length parameter, but every characters is randomized independetly with each loop.
     *
     * This function is based on FuelPHP's \Fuel\Core\Str random function.
     *
     * @param   string  $type       The type of random string to get
     * @param   int     $length     The length of the output string
     * @param   bool    $shuffle    Whether to shuffle the character pool to increase randomness (entropy)
     * @return  string  The type-random string containing random characters from the proper type pool
     */
    public static function trandom($type = 'alnum', $length = 16, $shuffle = false)
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
                break;
            case 'unique':
                return md5(uniqid(mt_rand()));
                break;
            case 'sha1':
                return sha1(uniqid(mt_rand(), true));
                break;
            case 'alpha':
                $pool = self::ALPHA;
                break;
            case 'alnum':
                $pool = self::ALNUM;
                break;
            case 'numeric':
                $pool = self::NUM;
                break;
            case 'nozero':
                $pool = static::sub(self::NUM, 1);
                break;
            case 'hexdec':
                $pool = self::HEXDEC;
                break;
            case 'distinct':
                $pool = self::DISTINCT;
                break;
            default:
                $pool = self::ALNUM;
                break;
        }

        return static::random($length, $pool, $shuffle);
    }

    /**
     * Verifies if a string begins with a substring.
     *
     * Verifies if a string begins with a substring. The $encoding parameter is used to determine the input string
     * encoding and thus use the proper method. The comparison is case-sensitive by default.
     *
     * @param   string  $input              The input string to compare to
     * @param   string  $search             The substring to compare the beginning to
     * @param   bool    $case_sensitive     Whether the comparison is case-sensitive
     * @param   string  $encoding           The encoding of the input string
     * @return  bool    Whether the input string begins with the given substring
     * @throws  \InvalidArgumentException
     */
    public static function beginsWith($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) or !is_string($search)) {
            throw new InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        $substr = static::sub($input, 0, static::length($search), $encoding);

        return !(($case_sensitive) ? strcmp($substr, $search) : strcasecmp($substr, $search));
    }

    /**
     * Verifies if a string ends with a substring.
     *
     * Verifies if a string ends with a substring. The $encoding parameter is used to determine the input string
     * encoding and thus use the proper method.
     *
     * @param   string  $input              The input string to compare to
     * @param   string  $search             The substring to compare the ending to
     * @param   bool    $case_sensitive     Whether the comparison is case-sensitive
     * @param   string  $encoding           The encoding of the input string
     * @return  bool    Whether the input string ends with the given substring
     * @throws  \InvalidArgumentException
     */
    public static function endsWith($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) or !is_string($search)) {
            throw new InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        if (($length = static::length($search, $encoding)) == 0) {
            return true;
        }

        $substr = static::sub($input, -$length, $length, $encoding);

        return !(($case_sensitive) ? strcmp($substr, $search) : strcasecmp($substr, $search));
    }

    public static function contains($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) or !is_string($search)) {
            throw new InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        if ($case_sensitive) {
            return function_exists('mb_strpos')
                ? mb_strpos($input, $search, 0, $encoding)
                : (strpos($input, $search) !== false ? true : false);
        } else {
            return function_exists('mb_stripos')
                ? mb_stripos($input, $search, 0, $encoding)
                : (stripos($input, $search) !== false ? true : false);
        }
    }

    /**
     * Verifies if the input string is one of the values of the given array.
     *
     * Verifies if the input string is one of the values of the given array. Each of the values
     * of the array is matched against the input string. The index of the value that matched can
     * be returned instead of the default bool value. The comparison can be case sensitive or
     * case insensitive (it is made with strcmp and strcasecmp respectively).
     *
     * @param   string      $input              The input string
     * @param   array       $values             The strings array to look for the input string
     * @param   bool        $case_sensitive     Whether the comparison is case-sensitive
     * @param   bool        $return_index       Whether to return the matched array's item instead
     * @return  bool|int    Whether the input string was found in the array or the item's index if found
     * @throws  \InvalidArgumentException
     */
    public static function isOneOf($input, array $values, $case_sensitive = true, $return_index = false)
    {
        if ($input === null) {
            return false;
        }

        if (!is_string($input)) {
            throw new InvalidArgumentException("The \$input parameter must be a string.");
        }

        foreach ($values as $index => $str) {
            if (!is_string($str)) {
                throw new InvalidArgumentException("The \$values array must contain only string values.");
            }

            if ($case_sensitive) {
                if (strcmp($input, $str) == 0) {
                    return ($return_index) ? $index : true;
                }
            } else {
                if (strcasecmp($input, $str) == 0) {
                    return ($return_index) ? $index : true;
                }
            }
        }

        return false;
    }

    /**
     * Converts a char(s)-separated string into studly caps.
     *
     * Converts a char(s)-separated string into studly caps. The string can be split using one or more
     * separators (being them a single char or a string). The $encoding parameter is used to determine the
     * input string encoding and thus use the proper method.
     * When the space char is not used as a separator, each word is converted to studly caps on its own,
     * otherwise the result will be a single studly-caps-cased string.
     *
     * @param   string  $input          The input string
     * @param   array   $separators     An array containing separators to split the input string
     * @param   string  $encoding       The encoding of the input string
     * @return  string  The studly-caps-cased string
     * @throws  \InvalidArgumentException
     */
    public static function studly($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input)) {
            throw new InvalidArgumentException("The \$input parameter must be a string.");
        }

        if (!empty($separators)) {
            $pattern = '';
            foreach ($separators as $separator) {
                if (!is_string($separator)) {
                    throw new InvalidArgumentException("The \$separators array must contain only strings.");
                }

                $pattern .= '|'.preg_quote($separator);
            }
            $pattern = '/(^'.$pattern.')(.)/e';

            $studly = preg_replace($pattern, "strtoupper('\\2')", strval($input));
            $words = explode(' ', $studly);
            foreach ($words as &$word) {
                $word = Str::ucfirst($word, $encoding);
            }
            $studly = implode(' ', $words);
        }

        return $studly;
    }

    /**
     * Converts a char(s)-separated string into camel case.
     *
     * Converts a char(s)-separated string into camel case. The string can be split using one or more
     * separators (being them a single char or a string). The $encoding parameter is used to determine
     * the input string encoding and thus use the proper method.
     * When the space char is not used as a separator, each word is converted to camel case on its own,
     * otherwise the result will be a single camel-cased string.
     *
     * @param   string  $input          The input string
     * @param   array   $separators     An array containing separators to split the input string
     * @param   string  $encoding       The encoding of the input string
     * @return  string  The camel-cased string
     * @throws  \InvalidArgumentException
     */
    public static function camel($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input)) {
            throw new InvalidArgumentException("The \$input parameter must be a string.");
        }

        $camel = static::studly($input, $separators, $encoding);
        $words = explode(' ', $camel);
        foreach ($words as &$word) {
            $word = Str::lcfirst($word, $encoding);
        }
        $camel = implode(' ', $words);

        return $camel;
    }

    /**
     * Converts a studly-caps-cased or camel-cased string into a char(s)-separated string using a given separator.
     *
     * Converts a studly-caps-cased or camel-cased string into a char(s)-separated string using a given separator.
     * Additionally it can run one of the following transformation in every separated word (words are split by a
     * space): 'lower', 'upper', 'lcfirst', 'ucfirst', 'ucwords' by using the $transform parameter (other values will
     * be ignored and no transformation will be made thus returning the separated words unmodified).
     *
     * @param   string          $input      The input string
     * @param   null|string     $transform  The transformation to be run for each word
     * @param   string          $separator  The separator to be used
     * @param   string          $encoding   The encoding of the input string
     * @return  string  The char(s)-separated string
     * @throws  \InvalidArgumentException
     */
    public static function separated($input, $transform = null, $separator = '_', $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) and !is_string($separator)) {
            throw new InvalidArgumentException("The \$input and \$separator parameters must be both strings.");
        }

        if ($separator == '') {
            throw new InvalidArgumentException("The \$separator parameters must have at least one character.");
        }

        $separated = preg_replace_callback('/(^.[^A-Z]+$)|(^.+?(?=[A-Z]))|( +)(.+?)(?=[A-Z])|([A-Z]+(?=$|[A-Z][a-z])|[A-Z]?[a-z]+)/',
            function($matches) use ($separator, $transform, $encoding)
            {
                $transformed = trim($matches[0]);
                $count_matches = count($matches);

                switch ($transform) {
                    case 'lower':
                        $transformed = Str::lower($transformed, $encoding);
                        break;
                    case 'upper':
                        $transformed = Str::upper($transformed, $encoding);
                        break;
                }

                $transformed = (($count_matches == 5) ? $matches[3] : '').$transformed;
                $transformed = (($count_matches == 6) ? $separator : '').$transformed;

                return $transformed;
            }, $input);

        // Do lcfirst and ucfirst transformations
        if (Str::isOneOf($transform, array('lcfirst', 'ucfirst', 'ucwords'))) {
            $words = explode(' ', $separated);
            foreach ($words as &$word) {
                switch ($transform) {
                    case 'lcfirst':
                        $word = Str::lcfirst($word, $encoding);
                        break;
                    case 'ucfirst':
                        $word = Str::ucfirst($word, $encoding);
                        break;
                    case 'ucwords':
                        // Because of how mb_convert_case works with MB_CASE_TITLE (underscore delimits words) we
                        // need to simulate it by lower + ucfirst
                        $word = Str::ucfirst(Str::lower($word, $encoding), $encoding);
                        break;
                }
            }
            $separated = implode(' ', $words);
        }

        return $separated;
    }

    /**
     * Truncates a string to the given length.
     *
     * Truncates a string to the given length. It will optionally preserve HTML tags if $is_html is set to true.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string  $string        The string to truncate
     * @param   int     $limit         The number of characters to truncate too
     * @param   string  $continuation  The string to use to denote it was truncated
     * @param   bool    $is_html       Whether the string has HTML
     * @return  string  The truncated string
     */
    public static function truncate($string, $limit, $continuation = '...', $is_html = false)
    {
        $offset = 0;
        $tags = array();
        if ($is_html) {
            // Handle special characters.
            preg_match_all('/&[a-z]+;/i', strip_tags($string), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[0][1] >= $limit) {
                    break;
                }
                $limit += (static::length($match[0][0]) - 1);
            }

            // Handle all the html tags.
            preg_match_all('/<[^>]+>([^<]*)/', $string, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[0][1] - $offset >= $limit) {
                    break;
                }

                $tag = static::sub(strtok($match[0][0], " \t\n\r\0\x0B>"), 1);
                if ($tag[0] != '/') {
                    $tags[] = $tag;
                } elseif (end($tags) == static::sub($tag, 1)) {
                    array_pop($tags);
                }

                $offset += $match[1][1] - $match[0][1];
            }
        }

        $new_string = static::sub($string, 0, $limit = min(static::length($string), $limit + $offset));
        $new_string .= (static::length($string) > $limit ? $continuation : '');
        $new_string .= count($tags = array_reverse($tags)) ? '</'.implode('></', $tags).'>' : '';

        return $new_string;
    }
}
