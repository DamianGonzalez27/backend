<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\UserRegisteredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Errores relacionados con la infraestructura y configuración del sistema
        $this->renderable(function (AdminException $exception, $request) {
            return $this->getResponse($exception->getMessage(), 500);
        });

        // Usuario ya registrado
        $this->renderable(function (UserRegisteredException $exception, $request) {
            return $this->getResponse($exception->getMessage());
        });

        $this->renderable(function (UserNotStoreRegistered $exception, $request) {
            return $this->getResponse($exception->getMessage());
        });

        // Tocken invalido
        $this->renderable(function (InvalidTokenException $exception, $request) {
            return $this->getResponse($exception->getMessage(), 401);
        });

        // Argumento invalido
        $this->renderable(function (InvalidArgunemt $exception, $request) {
            return $this->getResponse($exception->getMessage());
        });

        // Invalid credentials
        $this->renderable(function (BadCredentialsException $exception, $request) {
            return $this->getResponse($exception->getMessage(), 401);
        });

        // Recurso no encontrado
        $this->renderable(function (ItemNotFound $exception, $request) {
            return $this->getResponse($exception->getMessage(), 404);
        });

        $this->renderable(function (StoreExists $exception, $request) {
            return $this->getResponse($exception->getMessage(), 404);
        });
    }

    private function getResponse($message, $code = 409)
    {
        return response()->json(
            [
                'status' => 'error',
                'message' => $message
            ],
            $code
        );
    }
}
