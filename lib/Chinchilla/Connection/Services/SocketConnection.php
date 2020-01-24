<?php

namespace Chinchilla\Connection\Services;

use Chinchilla\Connection\Model\ConnectionOptions;
use Exception;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPSocketConnection;

/**
 * Class SocketConnection
 *
 * @package Chinchilla\Connection\Services
 */
class SocketConnection implements ConnectionInterface
{
    /**
     * @param ConnectionOptions $connectionOptions
     *
     * @return AbstractConnection
     * @throws Exception
     */
    public function createConnection(ConnectionOptions $connectionOptions): AbstractConnection
    {
        return new AMQPSocketConnection(
            $connectionOptions->getHost(),
            $connectionOptions->getPort(),
            $connectionOptions->getUsername(),
            $connectionOptions->getPassword(),
            $connectionOptions->getVhost(),
            $connectionOptions->isInsist(),
            $connectionOptions->getLoginMethod(),
            $connectionOptions->getLoginResponse(),
            $connectionOptions->getLocale(),
            $connectionOptions->getReadWriteTimeout(),
            $connectionOptions->isKeepAlive()
        );
    }

}
