<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

use Flexi\Contracts\ValueObjects\ID;

/**
 * Contract for Repository Pattern
 * Standard interface for data persistence.
 */
interface RepositoryInterface
{
    /**
     * Find entity by ID.
     */
    public function findById(ID $id): ?EntityInterface;

    /**
     * Save entity.
     */
    public function save(EntityInterface $entity): bool;

    /**
     * Delete entity.
     */
    public function delete(EntityInterface $entity): bool;

    /**
     * Filter entities by criteria.
     */
    public function matching(CriteriaInterface $criteria): iterable;

    /**
     * Count entities by criteria.
     */
    public function count(CriteriaInterface $criteria): int;
}
