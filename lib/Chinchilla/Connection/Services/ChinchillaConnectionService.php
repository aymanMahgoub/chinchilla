<?php

namespace Chinchilla\Connection\Services;

use Chinchilla\Connection\Model\ConnectionOptions;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;

/**
 * Class ChinchillaConnectionService
 *
 * @package Chinchilla\Connection\Services
 */
class ChinchillaConnectionService
{
    /**
     * @param AMQPChannel        $channel
     * @param AbstractConnection $abstractConnection
     *
     * @throws Exception
     */
    public static function closeAmqpConnection(AMQPChannel $channel, AbstractConnection $abstractConnection)
    {
        $channel->close();
        $abstractConnection->close();
    }

    /**
     * @param string $connectionType
     *
     * @return AbstractConnection
     */
    public static function openAmqpConnection(string $connectionType)
    {
        $rabbitConnection = ConnectionFactory::getConnectionService($connectionType);
        $connectionOption = new ConnectionOptions();

        return $rabbitConnection->createConnection($connectionOption);
    }

}
