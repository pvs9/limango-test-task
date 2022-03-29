<?php

use App\Machine\EuroCoins;

it('provides correct coin values', function () {
    $coins = new EuroCoins();
    $expectedCoins = [
        0.01, 0.02, 0.05,
        0.1, 0.2, 0.5,
        1.0, 2.0,
    ];

    $providedCoins = $coins->getCoins();

    usort(
        $providedCoins,
        static fn (float $a, float $b) => bccomp($a, $b, 2)
    );

    expect($providedCoins)->toEqual($expectedCoins);
});
