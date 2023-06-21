<?php 

namespace Netvibes\Publicerrormessage;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;


class PublicErrorMessageService {
    
    static public function processErrors($request, Throwable $exception)
    {
        $errrorMessage = false; 
        $errorCode = false; 
        $details = []; 

        if ($exception instanceof ModelNotFoundException) {
            $errrorMessage = str_replace('App\\Models\\', '', $exception->getMessage());
            $errorCode = 404;
        }
        if ($exception instanceof ValidationException) {
            $errrorMessage = $exception->getMessage();
            $details = $exception->validator->errors()->all(); 
            $errorCode = 500;
        }
        
        




        if ($errrorMessage && $errorCode) {
            return response()->json(['error' => $errrorMessage, 'details' => $details], $errorCode);
        }

        return false;
    }
}
