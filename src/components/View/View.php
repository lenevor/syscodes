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

namespace Syscodes\Components\View;

use Throwable;
use ArrayAccess;
use Traversable;
use BadMethodCallException;
use InvalidArgumentException;
use Syscodes\Components\Support\Str;
use Syscodes\Components\Collections\Arr;
use Syscodes\Components\Contracts\View\Engine;
use Syscodes\Components\Contracts\Support\Webable;
use Syscodes\Components\Contracts\Support\Arrayable;
use Syscodes\Components\Contracts\Support\Renderable;
use Syscodes\Components\Contracts\View\View as ViewContract;

/**
 * This class control the views.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class View implements ArrayAccess, Webable, ViewContract
{
	/**
	 * Array of local variables.
	 *
	 * @var array $data
	 */
	protected $data = [];

	/**
	 * The engine implementation.
	 * 
	 * @var \Syscodes\Components\Contracts\View\Engine $engine
	 */
	protected $engine;

	/**
	 * The view factory instance.
	 * 
	 * @var \Syscodes\Components\View\factory $factory
	 */
	protected $factory;

	/**
	 * The path to the view file.
	 * 
	 * @var string $path
	 */
	protected $path;

	/**
	 * Get the name of the view.
	 *
	 * @var string $view
	 */
	protected $view;

	/**
	 * Constructor: Create a new view instance.
	 * 
	 * @param  \Syscodes\Components\View\factory  $factory
	 * @param  \Syscodes\Components\Contracts\View\Engine  $engine
	 * @param  string  $view
	 * @param  string  $path
	 * @param  array  $data
	 *
	 * @return void
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct(Factory $factory, Engine $engine, $view, $path, $data = [])
	{
		$this->factory = $factory;
		$this->engine  = $engine;
		$this->view    = $view;
		$this->path    = $path;
		$this->data    = $data instanceof Arrayable ? $data->toArray() : (array) $data;
	}

	/**
	 * Get the string contents of the view.
	 *
	 * @example View::render();
	 *
	 * @param  \Callable|null  $callback  
	 * 
	 * @return array|string
	 * 
	 * @throws \Throwable
	 */
	public function render(Callable $callback = null)
	{
		try {
			$contents = $this->renderContents();

			$response = isset($callback) ? $callback($this, $contents) : null;

			$this->factory->flushStateIfDoneRendering();

			return ! is_null($response) ? $response : $contents;
		} catch(Throwable $e) {
			$this->factory->flushState();

			throw $e;
		}
	}

	/**
	 * Get the contents of the view instance.
	 * 
	 * @return void
	 */
	protected function renderContents()
	{
		$this->factory->increment();

		$contents = $this->getContents();

		$this->factory->decrement();

		return $contents;
	}

	/**
	 * Get the evaluated contents of the view.
	 * 
	 * @return string
	 */
	protected function getContents(): string
	{
		return $this->engine->get($this->path, $this->getArrayData());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getArrayData(): array
	{
		$data = array_merge($this->factory->getShared(), $this->data);
		
		return array_map(function ($value) {
			return ($value instanceof Renderable) ? $value->render() : $value;
		}, $data);
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderSections()
	{
		return $this->render(function () {
			return $this->factory->getSections();
		});
	}

	/**
	 * {@inheritdoc}
	 */
	public function assign($key, $value = null): self
	{
		if (is_array($key)) {
			$this->data = array_merge($this->data, $key);
		} else {
			$this->data[$key] = $value;
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function bind($key, & $value): self
	{
		$this->data[$key] =& $value;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * Get the name of the view.
	 * 
	 * @return string
	 */
	public function getView(): string
	{
		return $this->view;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPath($path): void
	{
		$this->path = $path;
	}

	/**
	 * Get the view factory instance.
	 * 
	 * @return \Syscodes\Components\View\factory
	 */
	public function getFactory()
	{
		return $this->factory;
	}

	/**
	 * Get the view's rendering engine.
	 * 
	 * @return \Syscodes\Components\Contracts\View\Engine
	 */
	public function getEngine()
	{
		return $this->engine;
	}

	/**
	 * Searches for the given variable and returns its value.
	 * Local variables will be returned before global variables.
	 *
	 * @example  $value = $view->get('foo', 'bar');
	 *
	 * If the key is not given or null, the entire data array is returned.
	 *
	 * @param  string  $key      The variable name
	 * @param  mixed   $default  The default value to return 
	 *
	 * @return mixed
	 *
	 * @uses   \Syscodes\Components\Contracts\Core\Lenevor
	 *
	 * @throws \InvalidArgumentException
	 */
	public function &get($key, $default = null)
	{
		if (strpos($key, '.') === false) {
			if (array_key_exists($key, $this->data)) {
				return $this->data[$key];
			} else {
				throw new InvalidArgumentException(__('view.variableNotSet'));
			}
		} else {
			return value($default);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function set($key, $value = null): self
	{
		if (is_array($key) || $key instanceof Traversable) {
			foreach ($key as $name => $value) {
				$this->assign($name, $value);
			}
		} else {
			if (strpos($key, '.') === false) {
				$this->data[$key] = $value;
			} else {
				Arr::set($this->data, $key, $value);
			}
		}

		return $this;
	}

	/*
	|-----------------------------------------------------------------
	| ArrayAccess Methods
	|-----------------------------------------------------------------
	*/

	/**
	 * Whether or not an offset exists.
	 * 
	 * @param  string  $offset
	 * 
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->data);
	}

	/**
	 * Returns the value at specified offset.
	 * 
	 * @param  string  $offset
	 * 
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->data[$offset];
	}

	/**
	 * Assigns a value to the specified offset
	 * 
	 * @param  string  $offset
	 * @param  mixed  $value
	 * 
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->assign($offset, $value);
	}

	/**
	 * Unsets an offset.
	 * 
	 * @param  string  $offset
	 * 
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}

	/**
	 * Magic method.
	 * 
	 * Searches for the given variable and returns its value.
	 * Local variables will be returned before global variables.
	 *
	 * @example $value = $view->var;
	 * 
	 * @param  string  $key  Variable name
	 *
	 * @return mixed
	 *
	 * @throws \Syscodes\Components\LenevorException
	 */
	public function &__get($key) 
	{
		return $this->get($key);
	}

	/**
	 * Magic method.
	 * 
	 * Calls [$this->set] with the same parameters.
	 *
	 * @example $view->var = 'something';
	 *
	 * @param  string  $key    Variable name
	 * @param  mixed   $value  Value
	 *
	 * @return void
	 */
	public function __set($key, $value) 
	{
		$this->set($key, $value);
	}

	/**
	 * Magic method.
	 * 
	 * Determines if a variable is set.
	 *
	 * @example isset($view->foo);
	 *
	 * Variables are not considered to be set.
	 *
	 * @param  string  $key  variable name
	 *
	 * @return boolean
	 */
	public function __isset($key) 
	{
		return isset($this->data[$key]);
	}

	/**
	 * Magic method.
	 * 
	 * Unsets a given variable.
	 *
	 * @example unset($view->var);
	 *
	 * @param  string  $key  Variable name
	 *
	 * @return void
	 */
	public function __unset($key) 
	{
		unset($this->data[$key]);
	}

	/**
	 * Magic Method for handling dynamic functions.
	 * 
	 * @param  string  $method
	 * @param  array  $parameters
	 * 
	 * @return mixed
	 * 
	 * @throws \BadMethodCallException;
	 */
	public function __call($method, $parameters)
	{
		if (Str::startsWith($method, 'assign')) {
			$name = Str::camelcase(substr($method, 4));

			return $this->assign($name, $parameters[0]);
		}

		throw new BadMethodCallException(sprintf(
			'Method %s::%s does not exist.', static::class, $method)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function toHtml()
	{
		return $this->render();
	}

	/**
	 * Magic method.
	 * 
	 * Returns the output of [static::render].
	 *
	 * @return string
	 *
	 * @uses   View->render()
	 * 
	 * @throws \Throwable
	 */
	public function __toString() 
	{
		return $this->render();
	}
}