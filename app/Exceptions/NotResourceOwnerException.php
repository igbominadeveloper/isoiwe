<?php

namespace App\Exceptions;

use Exception;

class NotResourceOwnerException extends Exception
{
    public function render(){
        return $this->getErrorMessage();
    }

    public function getErrorMessage(){
        return ['errors' => 'Sorry, You do not own this resource'];
    }
}
