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

namespace Syscodes\Components\Routing;

use Syscodes\Components\Collections\Arr;

/**
 * This class uses an awaiting resource registration instance.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class AwaitingResourceRegistration
{
    /**
     * The resource controller.
     * 
     * @var string $controller
     */
    protected $controller;

    /**
     * The resource name.
     * 
     * @var string $name
     */
    protected $name;

    /**
     * The resource options.
     * 
     * @var array $options
     */
    protected $options = [];

    /**
     * The resource register.
     * 
     * @var \Syscodes\Components\Routing\ResourceRegister $register
     */
    protected $register;

    /**
     * The resource's registration status.
     * 
     * @var bool $registered
     */
    protected $registered = false;

    /**
     * Constructor. Create a new route resource registration instance.
     * 
     * @param  \Syscodes\Components\Routing\ResourceRegister  $register
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * 
     * @return void
     */
    public function __construct(ResourceRegister $register, $name, $controller, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->register = $register;
        $this->controller = $controller;
    }

    /**
     * Set the methods the controller should apply to.
     * 
     * @param  array|string  $methods
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function only($methods)
    {
        $this->options['only'] = is_array($methods) ? $methods : func_get_args();

        return $this;
    }

    /**
     * Set the methods the controller should exclude.
     * 
     * @param  array|string  $methods
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function except($methods)
    {
        $this->options['except'] = is_array($methods) ? $methods : func_get_args();

        return $this;
    }

    /**
     * Set the route names for controller actions.
     * 
     * @param  array|string  $names
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function names($names)
    {
        $this->options['names'] = $names;

        return $this;
    }

    /**
     * Set the route names for a controller action.
     * 
     * @param  string  $method
     * @param  string  $name
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function name($method, $name)
    {
        $this->options['names'][$method] = $name;

        return $this;
    }

    /**
     * Override the route parameter names.
     * 
     * @param  array|string  $parameters
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function parameters($parameters)
    {
        $this->options['parameters'] = $parameters;

        return $this;
    }

    /**
     * Override the route parameter's name.
     * 
     * @param  string  $previous
     * @param  string  $parameter
     * 
     * @return \Syscodes\Components\Routing\AwaitingResourceRegistration
     */
    public function parameter($previous, $parameter)
    {
        $this->options['parameters'][$previous] = $parameter;

        return $this;
    }

    /**
     * Register the resource route.
     * 
     * @return \Syscodes\Components\Routing\RouteCollection
     */
    public function register()
    {
        $this->registered = true;

        return $this->register->register(
            $this->name, $this->controller, $this->options
        );
    }

    /**
     * Handle the object's destruction.
     * 
     * @return void
     */
    public function __destruct()
    {
        if ( ! $this->registered) {
            $this->register();
        }
    }
}