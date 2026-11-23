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
 * @copyright   Copyright (c) 2019 - 2026 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 */

namespace Syscodes\Components\Contracts\Support;

use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * Allows the collection of items from an array.
 */
interface Collectable extends Arrayable, Countable, IteratorAggregate, Jsonable, JsonSerializable
{
    /**
     * Create a new instance with no items.
     * 
     * @return $this
     */
    public static function empty();

    /**
     * Create a new collection instance if the value isn't one already.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public static function make($items = []);

    /**
     * Add a method to the list of proxied methods.
     * 
     * @param  string  $method 
     * @return void
     */
    public static function proxy($method): void;

    /**
     * Create a collection with the given range.
     *
     * @param  int  $from
     * @param  int  $to
     * @param  int  $step
     * @param  iterable  ...$args
     * @return $this<int, int>
     */
    public static function range($from, $to, $step = 1, ...$args);

    /**
     * Wrap the given value in a collection if applicable.
     *
     * @param  iterable  $value
     * @param  mixed  $args 
     * @return array
     */
    public static function wrap($value, ...$args);

    /**
     * Get the underlying items from the given collection if applicable.
     *
     * @param  array  $value 
     * @return array
     */
    public static function unwrap($value);

    /**
     * Add an item in the collection.
     * 
     * @param  mixed  $item 
     * @return $this
     */
    public function add(mixed $item);

    /**
     * Get all of the items in the collection.
     * 
     * @return array
     */
    public function all();

    /**
     * Collapse the collection items into a single array.
     * 
     * @return $this
     */
    public function collapse();

    /**
     * Collect the values into a collection.
     *
     * @return \Syscodes\Components\Support\Collection
     */
    public function collect();

    /**
     * Creates a collection by using this collection for 
     * keys and other its values.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function combine(mixed $items);

    /**
     * Determine if an item exists in the collection.
     * 
     * @param  mixed  $key
     * @param  mixed  $operator
     * @param  mixed  $value 
     * @return bool
     */
    public function contains($key, mixed $operator = null, mixed $value = null): bool;

    /**
     * Determine if an item is not contained in the collection.
     *
     * @param  mixed  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return bool
     */
    public function doesntContain($key, $operator = null, $value = null): bool;

    /**
     * Chunk the underlying collection array.
     * 
     * @param  int  $size 
     * @return $this
     */
    public function chunk(int $size);

    /**
     * Count the number of items in the collection.
     * 
     * @return int
     */
    public function count(): int;

    /**
     * Diff the collection with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function diff(mixed $items);

    /**
     * Returns the items in a collection that are not present 
     * in the given items, using the callback.
     * 
     * @param  mixed  $items
     * @param  callable  $callback 
     * @return $this
     */
    public function diffUsing(mixed $items, callable $callback);

     /**
     * Returns the items in the collection when the keys and values 
     * are not present in the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function diffAssoc(mixed $items);

    /**
     * Returns the items in the collection when the keys and values 
     * are not present in the given items, using the callback.
     * 
     * @param  mixed  $items
     * @param  callable  $callback 
     * @return $this
     */
    public function diffAssocUsing(mixed $items, callable $callback);

    /**
     * Returns the items in the collection when the keys 
     * are not present in the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function diffKeys(mixed $items);

    /**
     * Returns the items in the collection when the keys are 
     * not present in the given items, using the callback.
     * 
     * @param  mixed  $items
     * @param  callable  $callback 
     * @return $this
     */
    public function diffKeyUsing(mixed $items, callable $callback);

    /**
     * Execute a callback over each item.
     * 
     * @param  callable  $callback 
     * @return $this
     */
    public function each(callable $callback);

    /**
     * Remove an item from the collection by key.
     * 
     * @param  string|array  $keys 
     * @return $this
     */
    public function erase($keys);

    /**
     * Indicate that the model's string representation should be escaped when __toString is invoked.
     * 
     * @param  bool  $escape 
     * @return $this
     */
    public function escapeWhenLoadingToString($escape = true);

    /**
     * Get all items exceptions with the specified keys.
     * 
     * @param  mixed  $keys
     * @return $this
     */
    public function except(mixed $keys);

    /**
     * Run a filter over each of the items.
     * 
     * @param  callable|null  $callback 
     * @return $this
     */
    public function filter(?callable $callback = null);
    
    /**
     * Get the first item from the collection.
     * 
     * @param  callable|null  $callback
     * @param  mixed  $default 
     * @return mixed
     */
    public function first(?callable $callback = null, mixed $default = null);

    /**
     * Flip the items in the collection.
     * 
     * @return $this
     */
    public function flip();

    /**
     * Get a flattened array of the items in the collection.
     * 
     * @return $this
     */
    public function flatten();

    /**
     * Get an item from the collection.
     * 
     * @param  mixed  $key
     * @param  mixed  $default 
     * @return mixed
     */
    public function get($key, mixed $default = null);

    /**
     * Determine if an item exists in the collection by key.
     * 
     * @param  mixed  $key 
     * @return bool
     */
    public function has(mixed $key): bool;
    
    /**
     * Concatenate values of a given key as a string.
     * 
     * @param  string  $value
     * @param  string|null  $string 
     * @return string
     */
    public function implode(string $value, ?string $string = null): string;

    /**
     * Intersect the collection with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function intersect(mixed $items);

    /**
     * Intersect the collection with the given items by key.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function intersectKey(mixed $items);

    /**
     * Determine if the collection is empty or not.
     * 
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if the collection is not empty.
     * 
     * @return bool
     */
    public function isNotEmpty(): bool;
    
    /**
     * Reset the keys of the collection.
     * 
     * @return $this
     */
    public function keys();

    /**
     * Get the last item from the collection.
     * 
     * @param  callable|null  $callback
     * @param  mixed|null  $default 
     * @return mixed
     */
    public function last(?callable $callback = null, mixed $default = null);

    /**
     * Run a map over each of the items.
     * 
     * @param  callable  $callback 
     * @return $this
     */
    public function map(callable $callback);

    /**
     * Run an associative map over each of the items.
     * 
     * @param  callable  $callback 
     * @return $this
     */
    public function mapKeys(callable $callback);

    /**
     * Merge the collection with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function merge(array $items);

    /**
     * Recursively Merge the collection with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function mergeRecursive($items);

    /**
     * Get the items with the specified keys.
     * 
     * @param  mixed  $keys 
     * @return $this
     */
    public function only(mixed $keys);

    /**
     * Pad collection to the specified length with a value.
     * 
     * @param  int  $size
     * @param  mixed  $value 
     * @return $this
     */
    public function pad(int $size, mixed $value);

    /**
     * Get the values of a given key.
     * 
     * @param  string|array|int|null  $value
     * @param  string|null  $key 
     * @return $this
     */
    public function pluck($value, ?string $key = null);

    /**
     * Get and remove the last item from the collection.
     * 
     * @return mixed
     */
    public function pop(): mixed;

    /**
     * Get and remove an item from the collection.
     * 
     * @param  mixed  $key
     * @param  mixed|null  $default 
     * @return mixed
     */
    public function pull(mixed $key, mixed $default = null);

    /**
     * Put an item in the collection by key.
     * 
     * @param  mixed  $key
     * @param  mixed  $value 
     * @return $this
     */
    public function put(mixed $key, mixed $value);

    /**
     * Reduce the collection to a single value.
     * 
     * @param  callable  $callback
     * @param  mixed|null  $initial 
     * @return mixed
     */
    public function reduce(callable $callback, mixed $initial = null): mixed;

    /**
     * Replace the collection items with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function replace(mixed $items);

    /**
     * Recursively replace the collection items with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function replaceRecursive(mixed $items);

    /**
     * Reverse items order.
     * 
     * @return $this
     */
    public function reverse();

    /**
     * Search the collection for a given value and return the corresponding key if successful.
     * 
     * @param  mixed  $value
     * @param  bool  $strict 
     * @return mixed
     */
    public function search(mixed $value, bool $strict = false): mixed;

    /**
     * Get one or more items randomly from the collection.
     * 
     * @param  int  $amount 
     * @return mixed
     */
    public function random(int $amount = 1): mixed;

    /**
     * Get and remove the first item from the collection.
     * 
     * @return array
     */
    public function shift(): array;
    
    /**
     * Skip the first {$count} items.
     * 
     * @param  int  $count 
     * @return $this
     */
    public function skip(int $count);

    /**
     * Slice the underlying collection array.
     * 
     * @param  int  $offset
     * @param  int|null  $length 
     * @return $this
     */
    public function slice(int $offset, ?int $length = null);

    /**
     * Sort through each item.
     * 
     * @param  callable|int|null  $callback 
     * @return $this
     */
    public function sort($callback = null);

    /**
     * Sort items in descending order.
     * 
     * @param  int  $options 
     * @return $this
     */
    public function sortDesc(int $options = SORT_REGULAR);

    /**
     * Sort the collection keys.
     * 
     * @param  int  $options
     * @param  bool  $descending 
     * @return $this
     */
    public function sortKeys(int $options = SORT_REGULAR, bool $descending = false);

    /**
     * Sort the collection keys in descending order.
     * 
     * @param  int  $options 
     * @return $this
     */
    public function sortKeysDesc(int $options =  SORT_REGULAR);

    /**
     * Sort the collection keys using a callback.
     * 
     * @param  callable  $callback
     * @return $this
     */
    public function sortKeysUsing(callable $callback);

    /**
     * Splice portion of the underlying collection array.
     * 
     * @param  int  $offset
     * @param  int|null  $length
     * @param  mixed  $replacement 
     * @return $this
     */
    public function splice(int $offset, ?int $length = null, mixed $replacement = []);

    /**
     * Take the first or last {$limit} items.
     * 
     * @param  int  $limit 
     * @return $this
     */
    public function take(int $limit);

    /**
     * Transform each item in the collection.
     * 
     * @param  callable  $callback 
     * @return $this
     */
    public function transform(callable $callback);

    /**
     * Union the collection with the given items.
     * 
     * @param  mixed  $items 
     * @return $this
     */
    public function union(mixed $items);

    /**
     * Return only unique items from the collection array.
     * 
     * @return $this
     */
    public function unique();

    /**
     * Reset the keys on the underlying array.
     * 
     * @return $this
     */
    public function values();
    
    /**
     * Get the collection of items as a plain array.
     * 
     * @return array
     */
    public function toArray(): array;

    /**
     * Apply the callback if the given "value" is (or resolves to) truthy.
     *
     * @param  bool  $value
     * @param  callable|null  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function when($value = null, ?callable $callback = null, ?callable $default = null);

    /**
     * Apply the callback if the collection is empty.
     *
     * @param  callable|null  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function whenEmpty(callable $callback, ?callable $default = null);

    /**
     * Apply the callback if the collection is not empty.
     *
     * @param  callable|null  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function whenNotEmpty(callable $callback, ?callable $default = null);

    /**
     * Apply the callback if the given "value" is (or resolves to) falsy.
     *
     * @param  \Closure|null  $value
     * @param  callable|null  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function unless($value = null, ?callable $callback = null, ?callable $default = null);

    /**
     * Apply the callback unless the collection is empty.
     *
     * @param  callable  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function unlessEmpty(callable $callback, ?callable $default = null);

    /**
     * Apply the callback unless the collection is not empty.
     *
     * @param  callable  $callback
     * @param  callable|null  $default 
     * @return $this
     */
    public function unlessNotEmpty(callable $callback, ?callable $default = null);

    /**
     * Magic method.
     * 
     * Dynamically access collection proxies.
     *
     * @param  string  $key 
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($key);

    /**
     * Magic method.
     * 
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString(): string;
}