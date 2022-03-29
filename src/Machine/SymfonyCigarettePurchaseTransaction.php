<?php

namespace App\Machine;

use App\Machine\Exception\InvalidItemQuantityException;
use App\Machine\Exception\InvalidPaidAmountException;
use Symfony\Component\Console\Input\InputInterface;

class SymfonyCigarettePurchaseTransaction implements PurchaseTransactionInterface
{
    private InputInterface $inputInterface;

    public function __construct(InputInterface $inputInterface)
    {
        $this->inputInterface = $inputInterface;
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        if (!$this->inputInterface->hasArgument('packs')) {
            throw new InvalidItemQuantityException();
        }

        $itemQuantity = $this->inputInterface->getArgument('packs');

        if (!is_numeric($itemQuantity)) {
            throw new InvalidItemQuantityException();
        }

        return (int) $itemQuantity;
    }

    /**
     * @return float
     */
    public function getPaidAmount(): float
    {
        if (!$this->inputInterface->hasArgument('amount')) {
            throw new InvalidItemQuantityException();
        }

        $paidAmount = \str_replace(',', '.', $this->inputInterface->getArgument('amount'));

        if (!is_numeric($paidAmount)) {
            throw new InvalidPaidAmountException();
        }

        return (float) $paidAmount;
    }
}
