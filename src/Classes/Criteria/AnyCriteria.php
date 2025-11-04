<?php

declare(strict_types=1);

namespace Flexi\Contracts\Classes\Criteria;

use Flexi\Contracts\Interfaces\CriteriaInterface;

/**
 * Generic criteria that matches any request without filtering.
 * Implements the Null Object pattern for criteria queries.
 * Used when no specific filtering criteria is needed.
 */
class AnyCriteria implements CriteriaInterface
{
    public function __toString(): string
    {
        return 'AnyCriteria: matches any request';
    }

    public function apply($request)
    {
        return $request;
    }
}
