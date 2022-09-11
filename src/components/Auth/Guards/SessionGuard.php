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

namespace Syscodes\Components\Auth\Guards;

use Syscodes\Components\Support\Traits\Macroable;
use Syscodes\Components\Contracts\Auth\StateGuard;
use Syscodes\Components\Contracts\Auth\Authenticatable;
use Syscodes\Components\Contracts\Auth\SupportedBasicAuth;
use Syscodes\Components\Auth\Concerns\GuardAuthenticationUser;

/**
 * Capture the user data using a session.
 * 
 * @author Alexander Campo <jalexam@gmail.com> 
 */
class SessionGuard implements StateGuard, SupportedBasicAuth
{
    use GuardAuthenticationUser,
        Macroable;

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $credentials = []): bool
    {
        return false;
    }

    /**
     * {@inheritdoc} 
     */
    public function basic($field = 'email', $extraConditions = [])
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function onceBasic($field = 'email', $extraConditions = [])
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function attempt(array $credentials = [], $remember = false): bool
    {
        return false;
    }    
    /**
     * {@inheritdoc}
     */
    public function once(array $credentials = []): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function login(Authenticatable $user, $remember = false): void
    {

    }    
    /**
     * {@inheritdoc}
     */
    public function loginUsingId($id, $remember = false)
    {

    }    
    /**
     * {@inheritdoc}
     */
    public function onceUsingId($id)
    {

    }    
    /**
     * {@inheritdoc}
     */
    public function viaRemember(): bool
    {
        return false;
    }    
    /**
     * {@inheritdoc}
     */
    public function logout(): void
    {

    }
}