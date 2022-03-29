<?php

namespace App\Machine;

/**
 * Interface PurchasableItemInterface
 * @package App\Machine
 */
interface PurchaseTransactionInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity(): int;

    /**
     * @return float
     */
    public function getPaidAmount(): float;
}
