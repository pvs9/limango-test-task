<?php

use App\Machine\CigaretteMachine;
use App\Machine\Exception\PurchaseTransactionValidationException;
use App\Machine\SymfonyCigarettePurchaseTransaction;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

it('runs execute correctly with correct data', function (int $packs, float $amount, array $change) {
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

    $cigaretteMachine = new CigaretteMachine();
    $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);

    expect($purchasedItem->getTotalAmount())->toBe((float) bcmul($cigaretteMachine->getItemPrice(), $packs, 2));
    expect($purchasedItem->getItemQuantity())->toBe($packs);
    expect($purchasedItem->getChange())->toEqual($change);
})->with([
    [1, 5.00, ['0.01' => 1]],
    [2, 15.00, ['2' => 2, '1' => 1, '0.02' => 1]],
    [4, 19.96, []],
    [3, 19.94, ['2' => 2, '0.5' => 1, '0.2' => 2, '0.05' => 1, '0.02' => 1]],
]);

it('throws exception if invalid input appears', function ($packs, $amount) {
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

    $cigaretteMachine = new CigaretteMachine();
    expect(fn() => $cigaretteMachine->execute($purchaseTransaction))->toThrow(InvalidArgumentException::class);
})->with([
    ['packs', 5.00],
    [1, 'amount'],
]);

it('throws exception if specification check fails', function (int $packs, float $amount) {
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

    $cigaretteMachine = new CigaretteMachine();
    expect(fn() => $cigaretteMachine->execute($purchaseTransaction))
        ->toThrow(PurchaseTransactionValidationException::class);
})->with([
    [-1, 5.00],
    [0, 5.00],
    [1, 4.98],
]);
