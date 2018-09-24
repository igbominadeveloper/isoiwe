<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait apiExceptionTrait
{
    public function apiException($request, $exception){
        if ($exception instanceof NotFoundHttpException){
            return $this->isHttp();
        }

        if ($exception instanceof ModelNotFoundException){
            return $this->isModel();
        }
        return parent::render($this->request, $this->exception);
    }
    public function isModel(){
        return $this->modelResponse();
    }

    public function isHttp(){
        return $this->httpResponse();
    }

    public function modelResponse(){
        return response()->json([
            'errors' => 'Model Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    public function httpResponse(){
        return response()->json([
            'errors' => 'Incorrect route'
        ], Response::HTTP_NOT_FOUND);
    }
}
