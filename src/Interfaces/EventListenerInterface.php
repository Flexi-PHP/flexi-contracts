<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

interface EventListenerInterface
{
    public function handle(EventInterface $event): void;
}
