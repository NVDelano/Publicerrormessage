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
        } elseif ($exception instanceof ValidationException) {
            $errrorMessage = $exception->getMessage();
            $details = $exception->validator->errors()->all(); 
            $errorCode = 500;
        } else {
            try {
                $errrorMessage = $exception->getMessage(); 
                $errorCode = $exception->getCode(); 
            } catch (\Throwable $th) {
            }
        }
        
       
        




        if ($errrorMessage && $errorCode) {
            if (!in_array($errorCode, [400, 401, 403, 404, 405, 422, 429, 500, 502, 503, 504])) {
                $errorCode = 500; // Default to 500 if not a valid HTML error code
            }
            return response()->json(['error' => $errrorMessage, 'details' => $details], $errorCode);
        }

        return false;
    }
}
