<?php

namespace App\Machine\Exception;

class InvalidPaidAmountException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid paid amount provided');
    }
}
