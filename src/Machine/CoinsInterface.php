<?php

namespace App\Machine;

interface CoinsInterface
{
    /**
     * @return float[]
     */
    public function getCoins(): array;
}
