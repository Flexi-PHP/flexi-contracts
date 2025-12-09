<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

use Flexi\Contracts\Classes\Criteria\Filters;
use Flexi\Contracts\Classes\Criteria\Order;

interface CriteriaInterface
{
    public function filters(): Filters;
    public function order(): Order;
    public function limit(): ?int;
    public function offset(): ?int;
    public function pointer(): ?int;
}
