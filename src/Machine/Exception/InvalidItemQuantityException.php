<?php

namespace App\Machine\Exception;

class InvalidItemQuantityException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid item quantity provided');
    }
}
