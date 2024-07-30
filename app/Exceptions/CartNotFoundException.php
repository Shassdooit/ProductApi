<?php

namespace App\Exceptions;

use Exception;

class CartNotFoundException extends Exception
{
    protected $message = 'Cart not found';
}
