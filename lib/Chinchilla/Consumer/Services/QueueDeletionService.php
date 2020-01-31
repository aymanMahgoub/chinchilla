<?php

namespace Chinchilla\Consumer\Services;

use Chinchilla\Connection\Constant\ConnectionTypeConstant;
use Chinchilla\Connection\Services\ChinchillaConnectionService;

/**
 * Class QueueDeletionService
 *
 * @package Chinchilla\Consumer\Services
 */
class QueueDeletionService
{
    /**
     * @param string $routingKey
     */
    public function partialDeleteQueue(string $routingKey): void
    {
        $chinchillaConnection = ChinchillaConnectionService::openAmqpConnection(
            ConnectionTypeConstant::SOCKET_CONNECTION_TYPE
        );
        $channel              = $chinchillaConnection->channel();
        $channel->queue_delete($routingKey);
    }

}