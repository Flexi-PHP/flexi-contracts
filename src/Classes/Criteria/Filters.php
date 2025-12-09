<?php

namespace Flexi\Contracts\Classes\Criteria;

final class Filters
{
    private array $filters;

    /**
     * @param array<Filter> $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public static function fromValues(array $values): self
    {
        return new self(
            ...array_map(
                fn(array $v) => new Filter($v['field'], $v['operator'], $v['value']),
                $values
            )
        );
    }

    public function all(): array
    {
        return $this->filters;
    }

    public function isEmpty(): bool
    {
        return empty($this->filters);
    }

    public function add(Filter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }
}