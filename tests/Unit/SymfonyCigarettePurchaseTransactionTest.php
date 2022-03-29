<?php

use App\Machine\Exception\InvalidItemQuantityException;
use App\Machine\Exception\InvalidPaidAmountException;
use App\Machine\SymfonyCigarettePurchaseTransaction;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

it('can parse item quantity from input interface', function () {
    $inputInterface = new ArrayInput(['packs' => 1], new InputDefinition([new InputArgument('packs')]));
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($inputInterface);

    expect($purchaseTransaction->getItemQuantity())->toBe(1);
});

it('can not parse strings as item quantity from input interface', function () {
    $inputInterface = new ArrayInput(['packs' => 'one'], new InputDefinition([new InputArgument('packs')]));
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($inputInterface);

    expect(fn() => $purchaseTransaction->getItemQuantity())->toThrow(InvalidItemQuantityException::class);
});

it('can parse paid amount from input interface', function () {
    $inputInterface = new ArrayInput(['amount' => 4.99], new InputDefinition([new InputArgument('amount')]));
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($inputInterface);

    expect($purchaseTransaction->getPaidAmount())->toBe(4.99);
});

it('can not parse strings as paid amount from input interface', function () {
    $inputInterface = new ArrayInput(['amount' => 'four euro'], new InputDefinition([new InputArgument('amount')]));
    $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($inputInterface);

    expect(fn() => $purchaseTransaction->getPaidAmount())->toThrow(InvalidPaidAmountException::class);
});
