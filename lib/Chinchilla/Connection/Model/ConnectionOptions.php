<?php

namespace Chinchilla\Connection\Model;

/**
 * Class ConnectionOptions
 *
 * @package Chinchilla\Connection\Model
 */
class ConnectionOptions
{
    /** @var string $host */
    protected $host;

    /** @var string $port */
    protected $port;

    /** @var string $userName */
    protected $userName;

    /** @var string $password */
    protected $password;

    /** @var string $vhost */
    protected $vhost;

    /** @var bool $insist */
    protected $insist;

    /** @var string $loginMethod */
    protected $loginMethod;

    /** @var string|null $loginResponse */
    protected $loginResponse;

    /** @var string $locale */
    protected $locale;

    /** @var float $connectionTimeout */
    protected $connectionTimeout;

    /** @var float $readWriteTimeout */
    protected $readWriteTimeout;

    /** @var string|null $context */
    protected $context;

    /** @var bool $keepalive */
    protected $keepalive;

    /** @var int $heartbeat */
    protected $heartbeat;

    /** @var float $channelRpcTimeout */
    protected $channelRpcTimeout;

    /** @var string|null $sslProtocol */
    protected $sslProtocol;

    /**
     * ConnectionOptions constructor.
     */
    public function __construct()
    {
        $this->host              = AMQP_HOST;
        $this->port              = AMQP_PORT;
        $this->userName          = AMQP_USERNAME;
        $this->password          = AMQP_PASSWORD;
        $this->vhost             = AMQP_VHOST;
        $this->insist            = AMQP_INSIST;
        $this->loginMethod       = AMQP_LOGIN_METHOD;
        $this->loginResponse     = AMQP_LOGIN_RESPONSE;
        $this->locale            = AMQP_LOCAL;
        $this->connectionTimeout = AMQP_CONNECTION_TIMEOUT;
        $this->readWriteTimeout  = AMQP_READ_WRITE_TIMEOUT;
        $this->context           = AMQP_CONTEXT;
        $this->keepalive         = AMQP_KEEP_ALIVE;
        $this->heartbeat         = AMQP_HEART_BEAT;
        $this->channelRpcTimeout = AMQP_CHANNEL_RPC_TIMEOUT;
        $this->sslProtocol       = AMQP_SSL_PROTOCOL;
    }

    /**
     * @return float
     */
    public function getChannelRpcTimeout(): float
    {
        return $this->channelRpcTimeout;
    }

    /**
     * @return float
     */
    public function getConnectionTimeout(): float
    {
        return $this->connectionTimeout;
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * @return int
     */
    public function getHeartbeat(): int
    {
        return $this->heartbeat;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getLoginMethod(): string
    {
        return $this->loginMethod;
    }

    /**
     * @return string|null
     */
    public function getLoginResponse(): ?string
    {
        return $this->loginResponse;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return float
     */
    public function getReadWriteTimeout(): float
    {
        return $this->readWriteTimeout;
    }

    /**
     * @return string|null
     */
    public function getSslProtocol(): ?string
    {
        return $this->sslProtocol;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }

    /**
     * @return bool
     */
    public function isInsist(): bool
    {
        return $this->insist;
    }

    /**
     * @return bool
     */
    public function isKeepalive(): bool
    {
        return $this->keepalive;
    }

}
