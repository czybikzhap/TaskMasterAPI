<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e): JsonResponse
    {
        // Handle API requests
        if ($request->is('api/*') || $request->expectsJson()) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions
     */
    private function handleApiException(Request $request, Throwable $e): JsonResponse
    {
        // Custom API exceptions
        if ($e instanceof ApiException) {
            return $e->render($request);
        }

        // Model not found
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Ресурс не найден.',
                'errors' => ['resource' => ['Запрашиваемый ресурс не существует.']],
                'status_code' => 404
            ], 404);
        }

        // Validation errors
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации данных.',
                'errors' => $e->errors(),
                'status_code' => 422
            ], 422);
        }

        // Route not found
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Маршрут не найден.',
                'errors' => ['route' => ['Запрашиваемый маршрут не существует.']],
                'status_code' => 404
            ], 404);
        }

        // Method not allowed
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Метод не разрешен для данного маршрута.',
                'errors' => ['method' => ['Используемый HTTP метод не поддерживается для данного маршрута.']],
                'status_code' => 405
            ], 405);
        }

        // Generic server error
        return response()->json([
            'success' => false,
            'message' => 'Внутренняя ошибка сервера.',
            'errors' => ['server' => ['Произошла непредвиденная ошибка.']],
            'status_code' => 500
        ], 500);
    }
}
