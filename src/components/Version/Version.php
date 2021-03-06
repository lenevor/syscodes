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

namespace Syscodes;

/**
 * Loads the version of system.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
final class Version 
{
    /**
     * Product name.
     */
    const PRODUCT = 'Lenevor Framework';

    /** 
     * Lenevor's version.
     */
    const RELEASE = 'v0.7.5';

    /**
     * Release status.
     */
    const STATUS = 'alpha.7-dev';

    /**
     * The codename in key.
     */
    const CODENAME = 'Polaris';

    /**
     * Data version.
     */
    const RELEASEDATE = 'Created 02-May-2019';

    /**
     * Copyright information.
     */
    const COPYRIGHT = 'All rights reserved';
    
    /**
     * Product copyrighting.
     */
    const COPY = '©';

    /**
     * Year actual.
     */
    const YEAR = '2021';

    /**
     * Gets a string version of " PHP normalized" for the Lenevor Framework.
     *
     * @return string  Short version
     */
    public static function shortVersion()
    {
        return self::COPY.' '.self::YEAR.' '.self::PRODUCT; 
    }

    /**
     * Gets a string version Lenevor under real All information Release.
     * 
     * @return string  Complete version
     */
    public static function longVersion()
    {
        return self::COPY.' '.self::YEAR.' '.self::COPYRIGHT.' - '.self::PRODUCT.' ' .self::RELEASE. ' '. 
               self::STATUS.' [ '.self::CODENAME.' ] '.self::RELEASEDATE;
    }
}