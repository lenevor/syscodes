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
 * @copyright   Copyright (c) 2019 - 2022 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 */

namespace Syscodes\Components\Contracts\Core;

use Syscodes\Components\Contracts\Container\Container;

/**
 * Allows the loading of service providers and functions to activate 
 * routes, environments and calls of main classes.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
interface Application extends Container
{
    /**
     * Get the version number of the application.
     * 
     * @return string
     */
    public function version(): string;

     /**
     * Set the base path for the application.
     *
     * @param  string  $path
     * 
     * @return self
     */
    public function setBasePath(string $path): self;

    /**
     * Get the base path of the Lenevor installation.
     *
     * @param  string  $path  Optionally, a path to append to the base path
     * 
     * @return string
     */
    public function basePath($path = ''): string;

    /**
     * Get the path to the bootstrap directory.
     *
     * @param  string  $path  Optionally, a path to append to the bootstrap path
     * 
     * @return string
     */
    public function bootstrapPath($path = ''): string;

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path  Optionally, a path to append to the config path
     * 
     * @return string
     */
    public function configPath($path = ''): string;

    /**
     * Get the path to the database directory.
     *
     * @param  string  $path  Optionally, a path to append to the database path
     * 
     * @return string
     */
    public function databasePath($path = ''): string;

    /**
     * Get the path to the lang directory.
     * 
     * @return string
     */
    public function langPath(): string;

    /**
     * Get the path to the public / web directory.
     * 
     * @return string
     */
    public function publicPath(): string;

    /**
     * Get the path to the resources directory.
     *
     * @param  string  $path $path  Optionally, a path to append to the resources path
     * @return string
     */
    public function resourcePath($path = ''): string;

    /**
     * Get the path to the storage directory.
     * 
     * @return string
     */
    public function storagePath(): string;

    /**
     * Get the path to the views directory.
     * 
     * @param  string  $path
     * 
     * @return string
     */
    public function viewPath($path = ''): string;

    /**
     * Run the given array of bootstap classes.
     * 
     * @param  string[]  $bootstrappers
     * 
     * @return void
     */
    public function bootstrapWith(array $bootstrappers): void;

    /**
     * Determine if middleware has been disabled for the application.
     * 
     * @return bool
     */
    public function skipGoingMiddleware(): bool;

    /**
     * Get the path to the environment file directory.
     * 
     * @return string
     */
    public function environmentPath(): string;

    /**
     * Get the environment file the application is using.
     * 
     * @return string
     */
    public function environmentFile(): string;

    /**
     * Get the fully qualified path to the environment file.
     * 
     * @return string
     */
    public function environmentFilePath(): string;

    /**
     * Set the environment file to be loaded during bootstrapping.
     * 
     * @param  string  $file
     * 
     * @return self
     */
    public function setEnvironmentFile($file): self;

     /**
     * Determine if application is in local environment.
     * 
     * @return bool
     */
    public function isLocal(): bool;

    /**
     * Determine if application is in production environment.
     * 
     * @return bool
     */
    public function isProduction(): bool;

    /**
     * Determine if the application is unit tests.
     * 
     * @return bool
     */
    public function isUnitTests(): bool;

    /**
     * Determine if the application has been bootstrapped before.
     * 
     * @return bool
     */
    public function hasBeenBootstrapped(): bool;

    /**
     * Register all of the configured providers.
     * 
     * @return void
     */
    public function registerConfiguredProviders(): void;

    /**
     * Register a service provider.
     * 
     * @param  \Syscodes\Components\Support\ServiceProvider|string  $provider
     * @param  bool  $force
     * 
     * @return \Syscodes\Components\Support\ServiceProvider
     */
    public function register($provider, $force = false);

    /**
     * Resolve a service provider instance from the class name.
     * 
     * @param  string  $provider
     * 
     * @return \Syscodes\Components\Support\ServiceProvider
     */
    public function resolveProviderClass($provider);

    /**
     * Load and boot all of the remaining deferred providers.
     *
     * @return void
     */
    public function loadDeferredProviders(): void;

    /**
     * Determine if the given id type has been bound.
     * 
     * @param  string  $id
     * 
     * @return bool
     */
    public function bound($id): bool;

    /**
     * Determine if the application has booted.
     * 
     * @return bool
     */
    public function isBooted(): bool;

    /**
     * Boot the application´s service providers.
     * 
     * @return void
     */
    public function boot(): void;

    /**
     * Register a new boot listener.
     * 
     * @param  callable  $callback
     * 
     * @return void
     */
    public function booting($callback): void;

    /**
     * Register a new 'booted' listener.
     * 
     * @param  callable  $callback
     * 
     * @return void
     */
    public function booted($callback): void;

    /**
     * Get the current application locale.
     * 
     * @return string
     */
    public function getLocale(): string;

    /**
     * Set the current application locale.
     * 
     * @param  string  $locale
     * 
     * @return void
     */
    public function setLocale($locale): void;

    /**
	 * Shutdown the application.
	 * 
	 * @return void
	 */
	public function shutdown(): void;
}