<?php

namespace App\Services\Queue;

use App\DTO\Queue\QueueDataDTO;
use App\Enums\Queue\QueueNameEnum;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueProducerService
{
    protected const int DELIVERY_MODE_PERSISTENT = 2;

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
        foreach (QueueNameEnum::getQueuesList() as $queueName) {
            $this->setupQueue($queueName);
        }
    }

    protected function setupQueue(QueueNameEnum $queueName): void
    {
        $dlxName = "{$queueName->value}_dlx";
        $dlqName = "{$queueName->value}_dead";

        $args = [
            'x-dead-letter-exchange' => ['S', $dlxName],
            'x-dead-letter-routing-key' => ['S', $dlqName]
        ];

        $this->channel->exchange_declare($dlxName, 'direct', false, true, false);
        $this->channel->queue_declare($dlqName, false, true, false, false);
        $this->channel->queue_bind($dlqName, $dlxName, $dlqName);
        $this->channel->queue_declare($queueName->value, false, true, false, false, false, $args);
    }

    protected function disconnect(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
