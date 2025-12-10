<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

/**
 * Interface for Command/Query Handlers
 * Pure interface without dependencies.
 */
interface HandlerInterface
{
    /**
     * Handle a DTO and return a message result.
     *
     * @return MessageInterface
     */
    public function handle(DTOInterface $dto): MessageInterface;
}
