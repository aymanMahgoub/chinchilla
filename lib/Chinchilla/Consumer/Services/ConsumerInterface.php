<?php

namespace Chinchilla\Consumer\Services;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ConsumerInterface
 *
 * @package Chinchilla\Consumer\Services
 */
interface ConsumerInterface
{
    /**
     * Flag for message ack
     */
    const MSG_ACK = 1;

    /**
     * Flag single for message nack and requeue
     */
    const MSG_SINGLE_NACK_REQUEUE = 2;

    /**
     * Flag for reject and requeue
     */
    const MSG_REJECT_REQUEUE = 0;

    /**
     * Flag for reject and drop
     */
    const MSG_REJECT = -1;

    /**
     * @param AMQPMessage $msg
     *
     * @return int
     */
    public function consume(AMQPMessage $msg): int;

}
