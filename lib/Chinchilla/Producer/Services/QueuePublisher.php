<?php

namespace Chinchilla\Producer\Services;

use Chinchilla\Connection\Model\ConnectionOptions;
use Chinchilla\Connection\Services\ConnectionFactory;
use Exception;
use InvalidArgumentException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
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
    private $producers;

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
        if (!$this->isValidRoutingKey($routingKey)) {
            throw new InvalidArgumentException('Passing undefined routingKey: '.$routingKey);
        }
        $amqpMessage    = $this->getAmqpMessage($body, $routingKey);
        $producer       = $this->producers[$routingKey];
        $amqpConnection = $this->getAmqpConnection($producer['connection']);
        $channel        = $amqpConnection->channel();
        $channel->queue_declare($routingKey);
        $channel->basic_publish($amqpMessage, '', $routingKey);
        $this->closeConnection($channel, $amqpConnection);
    }

    /**
     * @param AMQPChannel        $channel
     * @param AbstractConnection $abstractConnection
     *
     * @throws Exception
     */
    private function closeConnection(AMQPChannel $channel, AbstractConnection $abstractConnection)
    {
        $channel->close();
        $abstractConnection->close();
    }

    /**
     * @param string $connectionType
     *
     * @return AbstractConnection
     */
    private function getAmqpConnection(string $connectionType)
    {
        $rabbitConnection = ConnectionFactory::getConnectionService($connectionType);
        $connectionOption = new ConnectionOptions();

        return $rabbitConnection->createConnection($connectionOption);
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

    /**
     * @param string $routingKey
     *
     * @return bool
     */
    private function isValidRoutingKey(string $routingKey)
    {
        $producers = $this->queues['producers'];
        if (array_key_exists($routingKey, $producers)) {
            return true;
        }

        return false;
    }

}
