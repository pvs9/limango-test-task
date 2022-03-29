<?php

use App\Machine\CigaretteMachine;

it('returns item price from constant', function () {
    $cigaretteMachine = new CigaretteMachine();

    expect($cigaretteMachine->getItemPrice())->toBe(CigaretteMachine::ITEM_PRICE);
});
