<?php

namespace App\Services\Queue;

use App\DTO\Queue\QueueDataDTO;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueProducerService
{
    const int DELIVERY_MODE_PERSISTENT = 2;

    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function produce(QueueDataDTO $data): void
    {
        $this->connect();
        $data->addAdditionDate();
        $msg = new AMQPMessage($data->toJson(), ['delivery_mode' => self::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', $data->getQueueName());
        $this->disconnect();
    }

    protected function connect(): void
    {
        $this->connection = new AMQPStreamConnection(
            config('app.queue_host'),
            config('app.queue_port'),
            config('app.queue_user'),
            config('app.queue_password')
        );
        $this->channel = $this->connection->channel();
    }

    protected function disconnect(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
