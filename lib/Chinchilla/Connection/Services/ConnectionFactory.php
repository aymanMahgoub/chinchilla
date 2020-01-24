<?php

namespace Chinchilla\Connection\Services;

use Chinchilla\Connection\Constant\ConnectionTypeConstant;
use InvalidArgumentException;

/**
 * Class ConnectionFactory
 *
 * @package Chinchilla\Connection\Services
 */
class ConnectionFactory
{
    /**
     * @param string $name
     *
     * @return ConnectionInterface
     */
    public static function getConnectionService(string $name)
    {
        switch ($name) {
            case ConnectionTypeConstant::SOCKET_CONNECTION_TYPE:
                return new SocketConnection();
                break;
            default:
                throw new InvalidArgumentException(
                    'invalid argument name for AMQP connection type passing name: '.$name
                );
        }
    }

}
