<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait apiExceptions
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
    protected function isModel(){
        return $this->modelResponse();
    }

    protected function isHttp(){
        return $this->httpResponse();
    }

    protected function modelResponse(){
        return response()->json([
            'errors' => 'Model Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse(){
        return response()->json([
            'errors' => 'Incorrect route'
        ], Response::HTTP_NOT_FOUND);
    }
}
