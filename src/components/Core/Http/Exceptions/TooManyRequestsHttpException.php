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
 * @since       0.7.4
 */

namespace Syscodes\Core\Http\Exceptions;

use Throwable;

/**
 * It is activated when the user has sent too many requests in a given period of time.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class TooManyRequestsHttpException extends HttpException
{
	/**
	 * Get the HTTP status code.
	 * 
	 * @var int $code
	 */
	protected $code = 429;
	
	/**
	 * Initialize constructor. 
	 * 
	 * @param  int|string|null  $retryAfter  The number of seconds or HTTP-date after 
	 * 										 which the request may be retried  (null by default)
	 * @param  string|null  $message  (null by default)
	 * @param  \Throwable|null  $previous  (null by default)
	 * @param  array  $headers
	 * 
	 * @return void
	 */
	public function __construct(
		$retryAfter = null, 
		string $message = null, 
		Throwable $previous = null, 
		?int $code = 0,
		array $headers = []
	) {		
		if ($retryAfter) {
			$headers['Retry-After'] = $retryAfter;
		}

		parent::__construct(
			$this->code, 
			$message, 
			$previous, 
			$headers, 
			$code
		);
	}
}