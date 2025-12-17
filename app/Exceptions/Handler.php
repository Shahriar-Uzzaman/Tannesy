<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Illuminate\Database\QueryException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation errors.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        "current_password",
        "password",
        "password_confirmation",
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
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is("api/*")) {
            if ($request->expectsJson()) {
                if ($exception instanceof ValidationException) {
                    return $this->error(
                        "Form parameters are invalid",
                        422,
                        $exception->errors(),
                    );
                }

                if ($exception instanceof ModelNotFoundException) {
                    return $this->error("Resource not found", 404);
                }

                if ($exception instanceof QueryException) {
                    return $this->error("Database error occurred", 500, [
                        $exception->getMessage(),
                    ]);
                }

                if ($exception instanceof TransportExceptionInterface) {
                    return $this->error("Mail delivery failed", 500, [
                        $exception->getMessage(),
                    ]);
                }

                if ($exception instanceof RouteNotFoundException) {
                    return $this->error(
                        "Route not found or unauthorized access",
                        404,
                    );
                }

                if ($exception instanceof \Exception) {
                    return $this->error(
                        $exception->getMessage(),
                        $exception->getCode() ?: 500,
                    );
                }

                return $this->error("Internal server error", 500, [
                    $exception->getMessage(),
                ]);
            }
        }

        return parent::render($request, $exception);
    }
}
