<?php

namespace Chinchilla\Connection\Services;

use Chinchilla\Connection\Model\ConnectionOptions;
use PhpAmqpLib\Connection\AbstractConnection;

/**
 * Interface ConnectionInterface
 *
 * @package Chinchilla\Connection\Services
 */
interface ConnectionInterface
{
    /**
     * @param ConnectionOptions $connectionOptions
     *
     * @return AbstractConnection
     */
    public function createConnection(ConnectionOptions $connectionOptions): AbstractConnection;

}
