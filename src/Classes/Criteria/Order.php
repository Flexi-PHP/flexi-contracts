<?php

namespace Flexi\Contracts\Classes\Criteria;

final class Order
{

    public const ASC = 'ASC';
    public const DESC = 'DESC';
    private string $field;
    private string $direction;

    public function __construct(
        string $field,
        string $direction = self::ASC
    ) {
        $this->validateDirection($direction);
        $this->field = $field;
        $this->direction = $direction;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function direction(): string
    {
        return $this->direction;
    }

    public function isAsc(): bool
    {
        return $this->direction === 'ASC';
    }

    public function isDesc(): bool
    {
        return $this->direction === 'DESC';
    }

    private function validateDirection(string $direction): void
    {
        if (!in_array($direction, [self::ASC, self::DESC], true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid order direction "%s". Allowed values are "%s" and "%s".',
                    $direction,
                    self::ASC,
                    self::DESC
                )
            );
        }
    }
}