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
 * @since       0.1.1
 */

namespace Syscodes\Core\Bootstrap;

use Syscodes\Core\AliasLoader;
use Syscodes\Support\Facades\Facade;
use Syscodes\Contracts\Core\Application;

/**
 * Initialize boot the register facades from setting file called services.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class BootRegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Syscodes\Contracts\Core\Application  $app
     * 
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance($app->make('config')->get('services.aliases', []))->register();
    }
}