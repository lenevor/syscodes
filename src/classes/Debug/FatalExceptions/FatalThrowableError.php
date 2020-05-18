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
 * @author      Javier Alexander Campo M. <jalexcam@gmail.com>
 * @link        https://lenevor.com 
 * @copyright   Copyright (c) 2019-2020 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.2.0
 */

namespace Syscode\Debug\FatalExceptions;

use Throwable;
use TypeError;
use ParseError;
use ErrorException;

/**
 * Fatal Throwable Error.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class FatalThrowableError extends FatalErrorException
{
    /**
     * Gets the original class name.
     * 
     * @var string $originalClassName
     */
    protected $originalClassName;

    /**
     * Constructor. Initialize FatalThrowableError class.
     * 
     * @param  \Throwable  $exception
     * 
     * @return void
     */
    public function __construct(Throwable $exception)
    {
        $this->originalClassName = get_class($exception);

        if ($exception instanceof ParseError)
        {
            $severity = E_PARSE;
        }
        elseif ($exception instanceof TypeError)
        {
            $severity = E_RECOVERABLE_ERROR;
        }
        else
        {
            $severity = E_ERROR;
        }

        ErrorException::__construct(
            $exception->getMessage(), 
            $exception->getCode(), 
            $severity, 
            $exception->getFile(), 
            $exception->getLine(), 
            $exception->getPrevious()
        );

        $this->setTrace($exception->getTrace());
    }

    /**
     * Gets the original class name.
     * 
     * @return string
     */
    public function getOriginalClassName(): string
    {
        return $this->originalClassName;
    }
}