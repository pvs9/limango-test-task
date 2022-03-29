<?php

namespace App\Machine;

class EuroCoins implements CoinsInterface
{
    /**
     * @return float[]
     */
    public function getCoins(): array
    {
        return [
            0.01, 0.02, 0.05,
            0.1, 0.2, 0.5,
            1.0, 2.0,
        ];
    }
}
