<?php 

/**
 * Lenevor PHP Framework
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

namespace Syscodes\Database\Query;

/**
 * Get values for query sql.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class Expression
{
    /**
     * Get the value of the expression.
     * 
     * @var mixed $value
     */
    protected $value;

    /**
     * Constructor. Create a new Expression class instance.
     * 
     * @param  mixed  $value
     * 
     * @return void
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of the expression.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the value of the expression.
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}