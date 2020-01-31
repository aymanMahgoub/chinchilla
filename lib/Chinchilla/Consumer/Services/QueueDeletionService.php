<?php

namespace Chinchilla\Consumer\Services;

use Chinchilla\Connection\Constant\ConnectionTypeConstant;
use Chinchilla\Connection\Services\ChinchillaConnectionService;
use InvalidArgumentException;

/**
 * Class QueueDeletionService
 *
 * @package Chinchilla\Consumer\Services
 */
class QueueDeletionService
{
    /**
     * @param string $queueName
     */
    public function fullDeleteQueue(string $queueName): void
    {
        $queues = file_get_contents(AMQP_QUEUES);
        $queues = json_decode($queues, true);
        $consumers = $queues['consumers'];
        $producers = $queues['producers'];
        if (!array_key_exists($queueName, $queues['consumers'])
            && !array_key_exists(
                $queueName,
                $queues['producers']
            )) {
            throw new InvalidArgumentException('There is no queue found with this name : '.$queueName);
        }
        $this->partialDeleteQueue($queueName);
        unset($consumers[$queueName]);
        unset($producers[$queueName]);
        $queues['consumers'] = $consumers;
        $queues['producers'] = $producers;
        file_put_contents(AMQP_QUEUES, json_encode($queues));
    }

    /**
     * @param string $queueName
     */
    public function partialDeleteQueue(string $queueName): void
    {
        $chinchillaConnection = ChinchillaConnectionService::openAmqpConnection(
            ConnectionTypeConstant::SOCKET_CONNECTION_TYPE
        );
        $channel              = $chinchillaConnection->channel();
        $channel->queue_delete($queueName);
    }

}
