<?php

namespace App\Machine\Exception;

class PurchaseTransactionValidationException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('You are trying to buy less than 1 item or provided less money than needed');
    }
}
