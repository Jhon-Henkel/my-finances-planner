<?php

namespace App\Services\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueProducerService
{
    const int DELIVERY_MODE_PERSISTENT = 2;

    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('app.queue_host'),
            config('app.queue_port'),
            config('app.queue_user'),
            config('app.queue_password')
        );

        $this->channel = $this->connection->channel();
    }

    public function sendMessage(array $data): void
    {
        $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => self::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', 'create_user');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
