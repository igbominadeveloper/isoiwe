<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\NotResourceOwnerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;

trait apiExceptions
{
    public function apiException($request, $exception){
        if ($exception instanceof NotFoundHttpException) {
            return $this->isHttp($exception);
        }

        elseif ($exception instanceof ModelNotFoundException) {
            return $this->isModel($exception);
        }

        elseif ($exception instanceof ValidationException){
            return $this->isValidation($exception);
        }

        elseif ($exception instanceof AuthenticationException){
            return $this->isAuthentication($exception);
        }

        elseif ($exception instanceof QueryException){
            return $this->isQuery($exception);
        }

        elseif ($exception instanceof NotResourceOwnerException){
            return $this->isNotResourceOwner($exception);
        }

        return parent::render($this->request, $this->exception);
    }
    protected function isModel(){
        return $this->modelResponse();
    }

    protected function isQuery($exception){
        return $this->queryResponse($exception);
    }

    protected function isHttp(){
        return $this->httpResponse();
    }

    protected function isValidation($exception){
        return $this->validationResponse($exception);
    }

    protected function isAuthentication($exception){
        return $this->authenticationResponse($exception);
    }

    protected function isNotResourceOwner($exception){
        return $this->ownershipResponse($exception);
    }

    protected function modelResponse(){
        return response()->json([
            'errors' => 'Model Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse(){
        return response()->json([
            'errors' => "Incorrect Route"
        ], Response::HTTP_NOT_FOUND);
    }

    protected function validationResponse($exception){
        return response()->json(
            [
               'errors' => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function authenticationResponse($exception){
        return response()->json(
            [
               'errors' => $exception->errors()
            ], Response::HTTP_UNAUTHORIZED);
    }

    protected function queryResponse($exception){
        return response()->json(
            [
               'errors' => $exception->getErrors()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function ownershipResponse($exception){
        return response()->json($exception->getErrorMessage(),Response::HTTP_FORBIDDEN);
    }
}
