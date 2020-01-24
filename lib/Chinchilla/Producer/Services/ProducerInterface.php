<?php

namespace Chinchilla\Producer\Services;

/**
 * Interface ProducerInterface
 *
 * @package Chinchilla\Producer\Services
 */
interface ProducerInterface
{
    /**
     * @param string $body
     * @param string $routingKey
     */
    public function publish(string $body, string $routingKey): void;
}
