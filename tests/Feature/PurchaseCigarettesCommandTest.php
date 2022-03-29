<?php

use App\Command\PurchaseCigarettesCommand;
use Symfony\Component\Console\Tester\CommandTester;

it('executes correctly with correct data', function (int $packs, float $amount) {
    $commandTester = new CommandTester(new PurchaseCigarettesCommand());
    $commandTester->execute([
        'packs' => $packs,
        'amount' => $amount,
    ]);

    $commandTester->assertCommandIsSuccessful();
})->with([
    [1, 5.00],
    [2, 15.00],
    [4, 19.96],
    [3, 19.94],
]);

it('fails with incorrect data', function ($packs, $amount) {
    $commandTester = new CommandTester(new PurchaseCigarettesCommand());
    expect(fn () => $commandTester->execute([
        'packs' => $packs,
        'amount' => $amount,
    ]))->toThrow(InvalidArgumentException::class);
})->with([
    ['packs', 5.00],
    [2, 'amount'],
    [1, 4.98],
    [-1, 4.99],
]);
