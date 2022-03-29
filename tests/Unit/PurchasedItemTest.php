<?php

use App\Machine\EuroCoins;
use App\Machine\PurchasedItem;
use App\Machine\SymfonyCigarettePurchaseTransaction;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

it('gets correct item quantity', function (int $packs) {
    $interface = new ArrayInput(
        ['packs' => $packs, 'amount' => 4.99],
        new InputDefinition(
            [
                new InputArgument('packs'),
                new InputArgument('amount')
            ]
        )
    );
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($interface);
    $purchasedItem = new PurchasedItem(new EuroCoins(), $purchaseTransaction, 4.99);

    expect($purchasedItem->getItemQuantity())->toBe($packs);
})->with([1, 2, 3,]);

it('calculates correct total amount', function (int $packs, float $itemPrice) {
    $interface = new ArrayInput(
        ['packs' => $packs, 'amount' => 100.00],
        new InputDefinition(
            [
                new InputArgument('packs'),
                new InputArgument('amount')
            ]
        )
    );
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($interface);
    $purchasedItem = new PurchasedItem(new EuroCoins(), $purchaseTransaction, $itemPrice);

    expect($purchasedItem->getTotalAmount())->toBe((float) bcmul($itemPrice, $packs, 2));
})->with([
    [1, 4.99],
    [2, 7.44],
    [4, 1.22]
]);

it('calculates correct change amount', function (int $packs, float $amount, array $change) {
    $interface = new ArrayInput(
        ['packs' => $packs, 'amount' => $amount],
        new InputDefinition(
            [
                new InputArgument('packs'),
                new InputArgument('amount')
            ]
        )
    );
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($interface);
    $purchasedItem = new PurchasedItem(new EuroCoins(), $purchaseTransaction, 4.99);

    expect($purchasedItem->getChange())->toEqual($change);
})->with([
    [1, 5.00, ['0.01' => 1]],
    [2, 15.00, ['2' => 2, '1' => 1, '0.02' => 1]],
    [4, 19.96, []],
    [3, 19.94, ['2' => 2, '0.5' => 1, '0.2' => 2, '0.05' => 1, '0.02' => 1]]
]);
