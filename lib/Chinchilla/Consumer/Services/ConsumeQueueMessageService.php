<?php

namespace Chinchilla\Consumer\Services;

use Chinchilla\Connection\Services\ChinchillaConnectionService;
use ErrorException;
use Exception;
use InvalidArgumentException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Prophecy\Exception\Doubler\ClassNotFoundException;


/**
 * Class ConsumeQueueMessageService
 *
 * @package Chinchilla\Consumer\Services
 */
class ConsumeQueueMessageService
{
    /** @var array $queues */
    private $queues;

    /** @var array $consumers */
    private $consumers = [];

    /** @var callable|null $callback */
    private $callback;

    /**
     * QueuePublisher constructor.
     */
    public function __construct()
    {
        $queues       = file_get_contents(AMQP_QUEUES);
        $this->queues = json_decode($queues, true);
        if (!empty($this->queues)) {
            $this->consumers = $this->queues["consumers"];
        }
    }

    /**
     * @param string $queueName
     * @param int    $numberOfMessage
     *
     * @throws Exception
     */
    public function consumeMessageFormQueue(string $queueName, int $numberOfMessage)
    {
        if (!array_key_exists($queueName, $this->consumers)) {
            throw new InvalidArgumentException('Passing undefined queue name: '.$queueName);
        }
        $consumer = $this->consumers[$queueName];
        $this->setConsumerCallBack($consumer['callback']);
        $amqpConnection = ChinchillaConnectionService::openAmqpConnection($consumer['connection']);
        $channel        = $amqpConnection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $this->consume($channel, $queueName, $numberOfMessage);
        ChinchillaConnectionService::closeAmqpConnection($channel, $amqpConnection);
    }

    /**
     * @param string $callback
     */
    private function setConsumerCallBack(string $callback)
    {
        if (!class_exists($callback)) {
            throw new ClassNotFoundException('can not find this consumer class', $callback);
        }
        $callback = new $callback();
        if (!$callback instanceof ConsumerInterface) {
            throw new InvalidArgumentException('class must be instanceof ConsumerInterface class');
        }
        $callback = [$callback, 'consume'];
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('can not find declaration for method consume in this consumer');
        }
        $this->callback = $callback;
    }

    /**
     * @param AMQPChannel $channel
     * @param string      $queueName
     * @param int         $numberOfMessage
     *
     * @throws ErrorException
     */
    private function consume(AMQPChannel $channel, string $queueName, int $numberOfMessage)
    {
        $channel->basic_qos(null, $numberOfMessage, null);
        $channel->basic_consume(
            $queueName,
            $queueName,
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );
        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    /**
     * @param AMQPMessage $message
     */
    private function processMessage(AMQPMessage $message)
    {
        $processFlag = call_user_func($this->callback, $message);
        $this->handleMessageDelivery($message, $processFlag);
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if ($name == 'processMessage' and $this->callback !== null and $arguments[0] instanceof AMQPMessage) {
            $this->processMessage($arguments[0]);
        }
    }

    /**
     * @param AMQPMessage $message
     * @param int         $processFlag
     */
    private function handleMessageDelivery(AMQPMessage $message, int $processFlag)
    {
        /** @var AMQPChannel $channel */
        $channel     = $message->delivery_info['channel'];
        $deliveryTag = $message->delivery_info['delivery_tag'];
        if ($processFlag === ConsumerInterface::MSG_REJECT_REQUEUE || false === $processFlag) {
            $channel->basic_reject($deliveryTag, true);
        } else if ($processFlag === ConsumerInterface::MSG_SINGLE_NACK_REQUEUE) {
            $channel->basic_nack($deliveryTag, false, true);
        } else if ($processFlag === ConsumerInterface::MSG_REJECT) {
            $channel->basic_reject($deliveryTag, false);
        } else {
            $channel->basic_ack($deliveryTag);
        }
    }

}
