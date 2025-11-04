<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

interface FactoryInterface
{
    public static function getInstance(...$args): object;
}
