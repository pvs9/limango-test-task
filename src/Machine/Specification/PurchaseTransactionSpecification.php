<?php

namespace App\Machine\Specification;

use App\Machine\PurchaseTransactionInterface;

class PurchaseTransactionSpecification implements PurchaseTransactionSpecificationInterface
{
    private float $itemPrice;

    public function __construct(float $itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    public function isSatisfiedBy(PurchaseTransactionInterface $item): bool
    {
        $itemQuantity = $item->getItemQuantity();
        $neededAmount = (float) bcmul($this->itemPrice, $itemQuantity, 2);

        return !($itemQuantity <= 0 || bccomp($item->getPaidAmount(), $neededAmount, 2) === -1);
    }
}
