<?php

namespace App\Machine\Specification;

use App\Machine\PurchaseTransactionInterface;

interface PurchaseTransactionSpecificationInterface
{
    public function isSatisfiedBy(PurchaseTransactionInterface $item): bool;
}
