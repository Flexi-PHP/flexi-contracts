<?php

namespace Flexi\Contracts\Interfaces;

use Psr\Http\Message\ServerRequestInterface;

interface CriteriaConverterInterface
{
    public function apply(object $queryBuilder,CriteriaInterface $criteria): void;

    public static function fromRequest(ServerRequestInterface $request): CriteriaInterface;
}