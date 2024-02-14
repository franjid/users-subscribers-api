<?php

namespace Project\Infrastructure\Repository\Queue;

use Project\Infrastructure\Interfaces\Queue\QueueInterface;
use Symfony\Component\Messenger\MessageBus;

class Rabbitmq implements QueueInterface
{
    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    public function enqueue($event): void
    {
        $this->bus->dispatch($event);
    }
}
