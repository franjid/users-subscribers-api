<?php

require_once "vendor/autoload.php";

use Project\Domain\Event\CreateUserEvent;
use Project\Domain\Event\CreateUserEventHandler;
use Project\Domain\Service\UserService as DomainUserService;
use Project\Infrastructure\DbConnection;
use Project\Infrastructure\QueueConnection;
use Project\Infrastructure\Repository\Database\UserRepository;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceiver;
use Symfony\Component\Messenger\Envelope;

$receiver = new AmqpReceiver((new QueueConnection())->getConnection());
$userRepository = new UserRepository((new DbConnection())->getConnection());
$domainUserService = new DomainUserService($userRepository);

while (true) {
    $envelopes = $receiver->get();

    /** @var Envelope $envelope */
    foreach ($envelopes as $envelope) {
        $event = $envelope->getMessage();

        try {
            switch ($event::class) {
                case CreateUserEvent::class:
                    $handler = new CreateUserEventHandler($domainUserService);
                    $handler->__invoke($event);
                    break;
            }

            $receiver->ack($envelope);
        } catch (Exception $e) {
            $receiver->reject($envelope);
        }
    }
}

