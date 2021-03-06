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

namespace Syscodes\Redis;

use Predis\Client;

/**
 * Redis cache handler.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class RedisManager
{
    /**
     * The host address of the database.
     * 
     * @var array $clients
     */
    protected $clients;

    /**
     * Constructor. The new Redis connection instance.
     * 
     * @param  array  $servers
     * 
     * @return void
     */
    public function __construct(array $servers = [])
    {
        if (isset($servers['cluster']) && $servers['cluster']) {
            $this->clients = $this->createAggregateClient($servers);
        } else {
            $this->clients = $this->createSingleClient($servers);
        }
    }

    /**
     * Create a new aggregate client supporting sharding.
     * 
     * @param  array  $servers
     * 
     * @return array
     */
    protected function createAggregateclient(array $servers)
    {
        $servers = array_except($servers, ['cluster']);

        return ['default' => new Client(array_values($servers))];
    }

    /**
     * Create an array of single connection clients.
     * 
     * @param  array  $servers
     * 
     * @return array
     */
    protected function createSingleClient(array $servers)
    {
        $clients = [];

        foreach ($servers as $key => $server) {
            $clients[$key] = new Client(Server);
        }

        return $clients;
    }

    /**
     * Get a Redis connection by name.
     * 
     * @param  string  $name  (null by default)
     * 
     * @return \Predis\Connection\SingleConnectionInterface
     */
    public function connection($name = null)
    {
        $name = $name ?: 'default';

        if (isset($this->clients[$name])) {
            return $this->clients[$name];
        }
    }

    /**
     * Dynamically make a Redis connection.
     * 
     * @param  string  $method
     * @param  array  $parameters
     * 
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->connection()->{$method}(...$parameters);
    }
}