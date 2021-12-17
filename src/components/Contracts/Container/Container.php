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

namespace Syscodes\Components\Contracts\Container;

use Closure;
use Psr\Container\ContainerInterface;

/**
 * Class responsible of registering the bindings, instances and 
 * dependencies of classes when are contained for to be executes 
 * in the services providers.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
interface Container extends ContainerInterface
{
    /**
     * Alias a type to a diferent name.
     * 
     * @param  string  $id
     * @param  string  $alias
     * 
     * @return void
     */
    public function alias($id, $alias): void;

    /**
     * Register a binding with container.
     * 
     * @param  string  $id
     * @param  \Closure|string|null  $value
     * @param  bool  $singleton
     * 
     * @return void
     */
    public function bind($id, $value = null, bool $singleton = false): void;

    /**
     * Determine if the given id type has been resolved.
     *
     * @param  string  $id
     * 
     * @return bool
     */
    public function resolved($id): bool;

    /**
     * Extender an id type in the container.
     *
     * @param  string    $id
     * @param  \Closure  $closure
     * 
     * @return mixed
     */
    public function extend($id, Closure $closure);
    
    /**
     * Register a singleton binding in the container.
     * 
     * @param  string  $id
     * @param  \Closure|string|null  $value
     * 
     * @return void
     */
    public function singleton($id, $value = null): void;

    /**
     * Instantiate a class instance of the given type.
     * 
     * @param  string  $class
     * 
     * @return mixed
     * 
     * @throws \Syscodes\Components\Contracts\Container\BindingResolutionException
     */
    public function build($class);

     /**
     * Marks a callable as being a factory service.
     * 
     * @param  string  $id
     * 
     * @return \Closure
     */
    public function factory($id): Closure;

    /**
     * Get the alias for an id if available.
     * 
     * @param  string  $id
     * 
     * @return string
     */
    public function getAlias($id): string;

    /**
     * Return and array containing all bindings.
     * 
     * @return array
     */
    public function getBindings(): array;

     /**
     * Register an existing instance as singleton in the container.
     *
     * @param  string  $id
     * @param  mixed  $instance
     * 
     * @return mixed
     */
    public function instance($id, $instance);

    /**
     * Return all defined value binding.
     * 
     * @return array
     */
    public function keys(): array;

    /**
     * An alias function name for make().
     * 
     * @param  string  $id
     * @param  array  $parameters
     * 
     * @return mixed
     */
    public function makeAssign($id, array $parameters = []);

    /**
     * Resolve the given type from the container.
     * 
     * @param  string  $id
     * @param  array  $parameters
     * 
     * @return object
     */
    public function make($id, array $parameters = []);

    /**
     * Determine if a given string is an alias.
     * 
     * @param  string  $name
     * 
     * @return bool
     */
    public function isAlias($name): bool;

    /**
     * Call the given callable / class@method and inject its dependencies.
     * 
     * @param  \callable|string  $callback
     * @param  array  $parameters
     * @param  string|null  $defaultMethod
     * 
     * @return mixed
     */
    public function call($callback, array $parameters = [], string $defaultMethod = null);

    /**
     * Remove all id traces of the specified binding.
     * 
     * @param  string  $id
     * 
     * @return void
     */
    public function remove($id): void;

    /**
     * Set the binding with given key / value.
     * 
     * @param  string  $id
     * @param  string  $value
     * 
     * @return self
     */
    public function set($id, string $value): self;

    /**
     * Flush the container of all bindings and resolved instances.
     * 
     * @return void
     */
    public function flush(): void;
}