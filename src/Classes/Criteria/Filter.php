<?php

namespace Flexi\Contracts\Classes\Criteria;

final class Filter
{
    private string $field;
    private FilterOperator $operator;
    /**
     * @var mixed
     */
    private $value;
    public function __construct(
        string $field,
        FilterOperator $operator,
        $value
    ) {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}