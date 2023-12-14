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
 * @copyright   Copyright (c) 2019 - 2023 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 */

namespace Syscodes\Components\Mail;

use Syscodes\Components\Mail\Mailables\Email;

/**
 * Allows the configuration to type of message for send at mail user.
 */
class Message
{
    /**
     * The Email instance.
     * 
     * @var \Syscodes\Component\Email\Mailables\Mail $message
     */
    protected $message;

    /**
     * Constructor. Create a new Message class instance.
     * 
     * @param  \Syscodes\Components\Mail\Mailables\Email  $message
     * 
     * @return void
     */
    public function __construct(Email $message)
    {
        $this->message = $message;
    }
}