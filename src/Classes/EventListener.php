<?php

declare(strict_types=1);

namespace Flexi\Contracts\Classes;

use Flexi\Contracts\Interfaces\EventInterface;
use Flexi\Contracts\Interfaces\EventListenerInterface;

abstract class EventListener implements EventListenerInterface
{
    public function handle(EventInterface $event): void
    {
        $this->handleEvent($event);
    }

    abstract protected function handleEvent(EventInterface $event): void;
}
