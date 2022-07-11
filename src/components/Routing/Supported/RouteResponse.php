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

namespace Syscodes\Components\Routing\Supported;

use Syscodes\Components\Http\Response;
use Syscodes\Components\Http\JsonResponse;
use Syscodes\Components\Contracts\View\Factory;
use Syscodes\Components\Routing\Supported\Redirector;
use Syscodes\Components\Contracts\Routing\RouteResponse as ResponseContract;

/**
 * This class allows you to control the use of the HTTP response 
 * along with routes redirection.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class RouteResponse implements ResponseContract
{
    /**
     * The View class instance.
     * 
     * @var Syscodes\Components\Contracts\View\Factory $view
     */
    protected $view;

    /**
     * The Redirector class instance.
     * 
     * @var \Syscodes\Components\Routing\Redirector $redirector
     */
    protected $redirector;

    /**
     * Constructor. Create a new RouteResponse instance.
     * 
     * @param  \Syscodes\Components\Contracts\View\Factory  $factory
     * @param  \Syscodes\Components\Routing\Redirector  $redirector
     * 
     * @return void  
     */
    public function __construct(Factory $factory, Redirector $redirector)
    {
        $this->view       = $factory;
        $this->redirector = $redirector;
    }

    /**
     * {@inheritdoc}
     */
    public function make($body = '', $status = 200, array $headers = []): Response
    {
        return new Response($body, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function noContent($status = 204, array $headers = []): Response
    {
        return $this->make('', $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function view(
        $view, 
        array $data = [], 
        $status = 200, 
        array $headers = []
    ): Response {
        return $this->make(
            $this->view->make($view, $data), $status, $headers
        );
    }

    /**
     * {@inheritdoc}
     */
    public function json(
        $data = [], 
        $status = 200, 
        array $headers = [], 
        $options = 0
    ) {
        return new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectTo(
        $path, 
        $status = 302, 
        $headers = [], 
        $secure = null
    ) {
        return $this->redirector->to($path, $status, $headers, $secure);
    }
}