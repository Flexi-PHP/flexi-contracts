<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

interface LogRepositoryInterface
{
    public function save(LogInterface $log): void;
}
