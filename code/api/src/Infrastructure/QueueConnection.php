<?php

namespace Project\Infrastructure;

use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;

class QueueConnection
{
    public function getConnection(): Connection
    {
        return new Connection(
            [
                'host' => 'rabbitmq',
                'port' => 5672,
                'vhost' => '/',
                'user' => 'guest',
                'password' => 'guest',
            ],
            [
                'name' => 'events'
            ],
            [
                'events' => []
            ]
        );
    }
}
