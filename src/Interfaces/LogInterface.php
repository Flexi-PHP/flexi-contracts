<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

use Flexi\Contracts\ValueObjects\LogLevel;

interface LogInterface
{
    public function getLogLevel(): LogLevel;

    public function getMessage(): MessageInterface;

    public function getContext(): array;

    public function __toString(): string;
}
