<?php

namespace Flexi\Contracts\Classes\Criteria;

use Flexi\Contracts\Interfaces\ValueObjectInterface;

final class FilterOperator implements ValueObjectInterface
{
    public const EQUAL = '=';
    public const NOT_EQUAL = '!=';
    public const GT = '>';
    public const GTE = '>=';
    public const LT = '<';
    public const LTE = '<=';
    public const LIKE = 'LIKE';
    public const NOT_LIKE = 'NOT_LIKE';
    public const IN = 'IN';
    public const NOT_IN = 'NOT_IN';
    public const IS_NULL = 'IS_NULL';
    public const IS_NOT_NULL = 'IS_NOT_NULL';
    public const BETWEEN = 'BETWEEN';

    private const VALID_OPERATORS = [
        self::EQUAL,
        self::NOT_EQUAL,
        self::GT,
        self::GTE,
        self::LT,
        self::LTE,
        self::LIKE,
        self::NOT_LIKE,
        self::IN,
        self::NOT_IN,
        self::IS_NULL,
        self::IS_NOT_NULL,
        self::BETWEEN,
    ];

    private string $operator;

    public function __construct(string $operator)
    {

        if (!self::isValid($operator)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid filter operator "%s".',
                    $operator
                )
            );
        }
        $this->operator = $operator;
    }

    private function isValid(string $operator): bool
    {
        return in_array($operator, self::VALID_OPERATORS, true);
    }

    public function getValue(): string
    {
        return $this->operator;
    }

    public function equals(ValueObjectInterface $other): bool
    {
        if (!$other instanceof self) {
            return false;
        }
        return $this->operator === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->operator;
    }
}