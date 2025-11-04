<?php

declare(strict_types=1);

namespace Flexi\Contracts\Classes;

use Flexi\Contracts\Interfaces\DTOInterface;
use Flexi\Contracts\Interfaces\EventInterface;
use Flexi\Contracts\Interfaces\EventListenerInterface;

abstract class EventListener implements EventListenerInterface
{
    public function handle(DTOInterface $dto): void
    {
        if ($dto instanceof EventInterface) {
            $this->handleEvent($dto);
        }
    }
}
