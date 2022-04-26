<?php

namespace App\Exceptions;

use Exception;
use ErrorException;

class ApiResponseException extends Exception
{
    
    //
    public function __construct($message){
        
        $this->message = $message;
    }

    public function getErrorMessage(){
        return $this->message;
    }

    public function render(){
        return response()->json([
            'status' => 'failed',
            'status_code' => '400',
            'message' => $this->message
        ], 400);
    }
}
