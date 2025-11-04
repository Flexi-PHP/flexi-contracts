<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

interface CriteriaInterface
{
    public function __toString(): string;

    public function apply($request);
}
