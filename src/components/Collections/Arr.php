<?php 

/**
 * Lenevor Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.md.
 * It is also available through the world-wide-web at this URL:
 * https://lenevor.com/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Lenevor.com so we can send you a copy immediately.
 *
 * @package     Lenevor
 * @subpackage  Base
 * @link        https://lenevor.com
 * @copyright   Copyright (c) 2019 - 2021 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 */

namespace Syscodes\Collections;

use ArrayAccess;
use InvalidArgumentException;

/**
 * Gets all a given array for return dot-notated key from an array.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class Arr
{
	/**
	 * Determine whether the value is accessible in a array.
	 *
	 * @param  mixed  $value The default value
	 *
	 * @return bool
	 *
	 * @uses   instanceof ArrayAccess
	 */
	public static function access($value) 
	{
		return is_array($value) || $value instanceof ArrayAccess;
	}

	/**
	 * Add an element to an array using "dot" notation if it doesn't exist.
	 *
	 * @param  array  $array  The search array 
	 * @param  string  $key  The key exist
	 * @param  mixed  $value  The default value
	 *
	 * @return array 
	 */
	public static function add($array, $key, $value)
	{
		if (is_null(static::get($array, $key))) {
			static::set($array, $key, $value);
		}

		return $array;
	}

	/**
     * Collapse the collection items into a single array.
     * 
     * @return static
     */
    public static function collapse($array)
    {
        $results = [];

        foreach ($array as $values) {
			if ($values instanceof Collection) {
				$values = $values->all();
			} elseif ( ! is_array($values)) {
				continue;
			}

			$results[] = $values;
        }

        return array_merge([], ...$results);
    }

	/**
	 * Divide an array into two arrays. One with keys and the other with values.
	 *
	 * @param  array  $array
	 *
	 * @return array
	 */
	public static function divide($array)
	{
		return [array_keys($array), array_values($array)];
	}

	/**
	 * Get all of the given array except for a specified array of items.
	 *
	 * @param  array  $array
	 * @param  string|array  $keys
	 *
	 * @return array
	 */
	public static function except($array, $keys)
	{
		static::erase($array, $keys);

		return $array;
	}
	
	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param  ArrayAccess|array  $array  The search array
	 * @param  string|int  $key  The key exist
	 *
	 * @return bool
	 *
	 * @uses   instaceof ArrayAccess
	 */
	public static function exists($array, $key) 
	{
		if ($array instanceof ArrayAccess) {
			return $array->offsetExists($key);
		}
		
		return array_key_exists($key, $array);
	}

	/**
	 * Unsets dot-notated key from an array.
	 *
	 * @param  array  $array  The search array
	 * @param  mixed  $keys  The dot-notated key or array of keys
	 *
	 * @return mixed
	 */
	public static function erase(&$array, $keys)
	{
		$original = &$array;

		$keys = (array) $keys;

		if (count($keys) === 0) {
			return;
		}

		foreach ($keys as $key) {
			if (static::exists($array, $key)) {
				unset($array[$key]);

				continue;
			}
			
			$parts = explode('.', $key);

			// Clean up after each pass
			$array = &$original;
	
			// traverse the array into the second last key
			while (count($parts) > 1) {
				$part = array_shift($parts);
	
				if (isset($array[$part]) && is_array($array[$part])) {
					$array = &$array[$key];
				} else {
					continue 2;
				}
			}

			unset($array[array_shift($parts)]);
		}
	}

	/**
	 * Flatten a multi-dimensional array into a single level.
	 * 
	 * @param  array  $array
	 * 
	 * @return array
	 */
	public static function flatten($array)
	{
		$result = [];

		array_walk_recursive($array, function ($value) use (&$result) {
			$result[] = $value;
		});

		return $result;
	}
	
	/**
	 * Fetch a flattened array of a nested array element.
	 * 
	 * @param  array  $array
	 * @param  string  $key
	 * 
	 * @return array
	 */
	public static function fetch($array, $key)
	{
		$segments = explode('.', $key);
		
		foreach ($segments as $segment) {
			$results = array();
			
			foreach ($array as $value) {
				if (array_key_exists($segment, $value = (array) $value)) {
					$results[] = $value[$segment];
				}
			}
			
			$array = array_values($results);
		}
		
		return array_values($results);
	}

	/**
	 * Return the first element in an array passing a given truth test.
	 *
	 * @param  array  $array 
	 * @param  \callable|null  $callback
	 * @param  mixed  $default
	 *
	 * @return mixed
	 */
	public static function first($array, callable $callback = null, $default = null)
	{
		foreach ($array as $key => $value) { 
			if (call_user_func($callback, $key, $value)) return $value;
		}

		return value($default);
	}	

	/**
	 * Get an item from an array using "dot" notation.
	 *
	 * @param  \ArrayAccess|array  $array  The search array
	 * @param  string  $key  The dot-notated key or array of keys
	 * @param  mixed  $default  The default value
	 *
	 * @return mixed
	 */
	public static function get($array, $key, $default = null)
	{
		if ( ! static::access($array)) {
			return value($default);
		}

		if (is_null($key)) {
			return $array;
		}

		if (static::exists($array, $key)) {
			return $array[$key];
		}

		$segments = explode('.', $key);

		foreach ($segments as $segment) {
			if (static::access($array) && static::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return value($default);
			}
		}

		return $array;		
	}

	/**
	 * Return the last element in an array passing a given truth test.
	 *
	 * @param  array  $array 
	 * @param  \callable|null  $callback
	 * @param  mixed  $default 
	 *
	 * @return mixed
	 *
	 * @uses   \Syscodes\Support\Arr::first
	 */
	public static function last($array, callable $callback = null, $default = null)
	{
		if (is_null($callback)) {
			return empty($array) ? value($default) : end($array);
		}
		
		return static::first(array_reverse($array), $callback, $default);
	}

	/**
	 * Check if an item exists in an array using "dot" notation.
	 * 
	 * @param  array  $array
	 * @param  string  $key
	 * 
	 * @return bool
	 */
	public static function has($array, $key)
	{
		if (empty($array) || is_null($key)) return false;
		
		if (static::exists($array, $key)) return true;

		$segments = explode('.', $key);
		
		foreach ($segments as $segment) {
			if ( ! is_array($array) || ! static::exists($array, $segment)) {
				return false;
			}
			
			$array = $array[$segment];
		}
		
		return true;
	}

	/**
	 * Get a subset of the items from the given array.
	 * 
	 * @param  array  $array
	 * @param  array|string  $keys
	 * 
	 * @return array
	 */
	public static function only($array, $keys)
	{
		return array_intersect_key($array, array_flip($array), $keys);
	}

	/**
	 * Sets a value in an array using "dot" notation.
	 *
	 * @param  array  $array  The search array
	 * @param  string  $key  The dot-notated key or array of keys
	 * @param  mixed  $value  The default value
	 *
	 * @return mixed
	 */
	public static function set(&$array, $key, $value = null)
	{
		if (is_null($key)) {
			return $array = $value;
		}

		$keys = explode('.', $key);

		while (count($keys) > 1) {
			$key = array_shift($keys);

			if ( ! static::exists($array, $key)) {
				$array[$key] = [];
			}

			$array = &$array[$key];
		}

		$array[array_shift($keys)] = $value;

		return $array;
	}

	/**
	 * Push an item onto the beginning of an array.
	 * 
	 * @param  mixed  $array
	 * @param  mixed  $value
	 * @param  mixed  key
	 * 
	 * @return array
	 */
	public static function prepend($array, $value, $key = null)
	{
		if (func_num_args() == 2) {
			array_unshift($array, $value);
		} else {
			$array = [$key => $value] + $array;
		}

		return $array;
	}

	/**
	 * Get a value from the array, and remove it.
	 * 
	 * @param  array  $array
	 * @param  string  $key
	 * @param  mixed  $default
	 * 
	 * @return mixed
	 */
	public static function pull(&$array, $key, $default = null)
	{
		$value = static::get($array, $key, $default);

		static::erase($array, $key);

		return $value;
	}
	
	/**
	 * Pluck an array of values from an array.
	 * 
	 * @param  iterable  $array
	 * @param  string|array|int|null  $value
	 * @param  string|array|null  $key
	 * 
	 * @return array
	 */
	public static function pluck($array, $value, $key = null)
	{
		$results = [];

		foreach ($array as $item) {
			$itemValue = is_object($item) ? $item->{$value} : $item[$value];
			
			// If the key is "null", we will just append the value to the array and keep
			// looping. Otherwise we will key the array using the value of the key we
			// received from the developer. Then we'll return the final array form.
			if (is_null($key)) {
				$results[] = $itemValue;
			} else {
				$itemKey = is_object($item) ? $item->{$key} : $item[$key];
				
				$results[$itemKey] = $itemValue;
			}
		}
		
		return $results;
	}

	/**
	 * Convert the array into a query string.
	 * 
	 * @param  array  $array
	 * 
	 * @return array
	 */
	public static function query($array)
	{
		return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
	}

	/**
	 * Filter the array using the given callback.
	 * 
	 * @param  array  $array
	 * @param  \Callable  $callback
	 * 
	 * @return array
	 */
	public static function where($array, Callable $callback)
	{
		return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
	}

	/**
	 * If the given value is not an array and not null, wrap it in one.
	 * 
	 * @param  mixed  $value
	 * 
	 * @return array
	 */
	public static function wrap($value)
	{
		if (is_null($value)) {
			return [];
		}

		return is_array($value) ? $value : [$value];
	}
}