<?php

namespace App\Machine;

use App\Machine\Exception\PurchaseTransactionValidationException;
use App\Machine\Specification\PurchaseTransactionSpecification;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    public const ITEM_PRICE = 4.99;

    public function getItemPrice(): float
    {
        return static::ITEM_PRICE;
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $specification = new PurchaseTransactionSpecification($this->getItemPrice());

        if (!$specification->isSatisfiedBy($purchaseTransaction)) {
            throw new PurchaseTransactionValidationException();
        }

        return new PurchasedItem(new EuroCoins(), $purchaseTransaction, $this->getItemPrice());
    }
}
