<?php

namespace App\Machine;

class PurchasedItem implements PurchasedItemInterface
{
    private PurchaseTransactionInterface $transaction;

    private CoinsInterface $coins;

    private float $itemPrice;

    public function __construct(CoinsInterface $coins, PurchaseTransactionInterface $transaction, float $itemPrice)
    {
        $this->coins = $coins;
        $this->transaction = $transaction;
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return integer
     */
    public function getItemQuantity(): int
    {
        return $this->transaction->getItemQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return (float) bcmul($this->itemPrice, $this->getItemQuantity(), 2);
    }

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array<string, int>
     */
    public function getChange(): array
    {
        $availableCoins = $this->coins->getCoins();

        usort(
            $availableCoins,
            static function (float $a, float $b) {
                $result = bccomp($a, $b, 2);

                return $result >= 0 ? -1 : 1;
            }
        );

        $neededChange = (float) bcsub($this->transaction->getPaidAmount(), $this->getTotalAmount(), 2);
        $change = [];

        if ($neededChange === 0.0) {
            return $change;
        }

        foreach ($availableCoins as $coin) {
            $neededCoins = (int) ($neededChange / $coin);

            if ($neededCoins > 0) {
                $change[(string)$coin] = (int) ($neededChange / $coin);
                $neededChange = (float) bcmod($neededChange, $coin, 2);

                if ($neededChange === 0.0) {
                    return $change;
                }
            }
        }

        return $change;
    }
}
