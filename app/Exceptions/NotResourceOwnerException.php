<?php

namespace App\Exceptions;

use Exception;

class sNotResourceOwnerException extends Exception
{
    public function render(){
        return $this->getErrorMessage();
    }

    public function getErrorMessage(){
        return ['errors' => 'Sorry, You do not own this resource'];
    }
}
