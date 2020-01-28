<?php

namespace Chinchilla\Producer\Services;

use Chinchilla\Connection\Services\ChinchillaConnectionService;
use Exception;
use InvalidArgumentException;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class QueuePublisher
 *
 * @package Chinchilla\Producer\Services
 */
class QueuePublisher
{
    /** @var array $queues */
    private $queues;

    /** @var array $producers */
    private $producers = [];

    /**
     * QueuePublisher constructor.
     */
    public function __construct()
    {
        $queues          = file_get_contents(AMQP_QUEUES);
        $this->queues    = json_decode($queues, true);
        if (!empty($this->queues)) {
            $this->producers = $this->queues["producers"];
        }
    }

    /**
     * @param string $body
     * @param string $routingKey
     *
     * @throws Exception
     */
    public function publish(string $body, string $routingKey): void
    {
        if (!array_key_exists($routingKey, $this->producers)) {
            throw new InvalidArgumentException('Passing undefined routing Key: '.$routingKey);
        }
        $amqpMessage    = $this->getAmqpMessage($body, $routingKey);
        $producer       = $this->producers[$routingKey];
        $amqpConnection = ChinchillaConnectionService::openAmqpConnection($producer['connection']);
        $channel        = $amqpConnection->channel();
        $channel->queue_declare($routingKey, false, true, false, false);
        $channel->basic_publish($amqpMessage, '', $routingKey);
        ChinchillaConnectionService::closeAmqpConnection($channel, $amqpConnection);
    }

    /**
     * @param string $body
     * @param string $routingKey
     *
     * @return AMQPMessage
     */
    private function getAmqpMessage(string $body, string $routingKey)
    {
        $producer   = $this->producers[$routingKey];
        $properties = $producer["properties"];

        return new AMQPMessage($body, $properties);
    }

}
