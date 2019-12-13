<?php

namespace App\Exceptions;

use Exception;

class UnathorizedException extends Exception
{
    public function render(){
        return ['data'=>'Unathorized Action'];
    }
}
