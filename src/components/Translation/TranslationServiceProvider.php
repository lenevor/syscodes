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

namespace Syscodes\Translation;

use Syscodes\Support\ServiceProvider;
use Syscodes\Contracts\Support\Deferrable;
use Syscodes\Translation\Loader\FileLoader;

/**
 * For loading the classes from the container of services.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class TranslationServiceProvider extends ServiceProvider implements Deferrable
{
    /**
     * Register the service provider.
     * 
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {            
            $locale = $this->app['config']['app.locale'];
            $loader = $app['translator.loader'];
            
            $translator = new Translator($locale, $loader);

            $translator->setFallback($app['config']['app.fallbackLocale']);

            return $translator;
        });
    }

    /**
     * Register the translation line loader.
     * 
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('translator.loader', function ($app) {
            return new FileLoader($app['files'], $app['path.lang']);
        });
    }

    /**
     * Get the services provided by the provider.
     * 
     * @return array
     */
    public function provides()
    {
        return [
            'translator', 'translator.loader',
        ];
    }
}