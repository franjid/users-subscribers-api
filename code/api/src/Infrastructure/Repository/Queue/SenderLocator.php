<?php

namespace Project\Infrastructure\Repository\Queue;

use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpSender;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;

class SenderLocator implements SendersLocatorInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getSenders(Envelope $envelope): iterable
    {
        return ['async' => new AmqpSender($this->connection)];
    }
}
