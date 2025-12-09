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

    public function filters(): Filters
    {
        return new Filters([new Filter('*', new FilterOperator('=='), '*')]);
    }

    public function order(): Order
    {
        return new Order('*');
    }

    public function limit(): ?int
    {
        return null;
    }

    public function offset(): ?int
    {
        return null;
    }

    public function pointer(): ?int
    {
        return null;
    }
}
