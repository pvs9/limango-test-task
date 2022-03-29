<?php

use App\Machine\Specification\PurchaseTransactionSpecification;
use App\Machine\SymfonyCigarettePurchaseTransaction;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

it('checks that item quantity is above zero', function (int $packs, bool $shouldSatisfy) {
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

    $specification = new PurchaseTransactionSpecification(4.99);
    expect($specification->isSatisfiedBy($purchaseTransaction))->toBe($shouldSatisfy);
})->with([
    [-1, false],
    [0, false],
    [1, true],
]);

it('checks that paid amount is enough', function (int $packs, float $amount, bool $shouldSatisfy) {
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

    $specification = new PurchaseTransactionSpecification(4.99);
    expect($specification->isSatisfiedBy($purchaseTransaction))->toBe($shouldSatisfy);
})->with([
    [1, 2.99, false],
    [1, 4.99, true],
    [1, 6.99, true],
    [2, 4.99, false],
    [2, 9.98, true],
    [2, 11.98, true],
]);
