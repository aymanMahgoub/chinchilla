<?php

namespace chinchilla\tests;

include('config.php');

use Chinchilla\Connection\Model\ConnectionOptions;
use Chinchilla\Connection\Services\ConnectionFactory;
use Chinchilla\Connection\Services\ConnectionInterface;
use Chinchilla\Connection\Services\SocketConnection;
use PhpAmqpLib\Connection\AbstractConnection;
use PHPUnit\Framework\TestCase;
use Chinchilla\Connection\Constant\ConnectionTypeConstant;

/**
 * Class TestConnection
 *
 * @package tests\Rabbitmq\Services
 */
class TestConnection extends TestCase
{
    public function testGetSocketConnection()
    {
        $connectionFactory = new ConnectionFactory();
        $this->assertInstanceOf(
            ConnectionInterface::class,
            $connectionFactory::getConnectionService(ConnectionTypeConstant::SOCKET_CONNECTION_TYPE)
        );
    }

    public function testSocketCreatConnection()
    {
        $socketConnection = new SocketConnection();
        $connectionOption = new ConnectionOptions();
        $this->assertInstanceOf(AbstractConnection::class, $socketConnection->createConnection($connectionOption));
    }

}
