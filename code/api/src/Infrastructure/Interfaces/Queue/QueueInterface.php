<?php

namespace Project\Infrastructure\Interfaces\Queue;

interface QueueInterface
{
    public function enqueue($event);
}
