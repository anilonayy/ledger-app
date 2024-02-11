<?php

namespace App\Exceptions;

use App\Enums\ResponseMessageEnums;
use App\Helpers\Api;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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

    public function render($request, Throwable $e)
    {
        if ($this->isProductionEnv($request)) {
            return Api::dynamic($this->getStatusCode($e, $request), null, $this->getMessage($e));
        }

        return parent::render($request, $e);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isProductionEnv(Request $request): bool
    {
        return config('app.env') === 'production' || $request->header('X-Production') === 'true';
    }

    /**
     * @param Throwable $e
     * @return string
     */
    protected function getMessage(Throwable $e): string
    {
        $message = $e->getMessage();

        return !empty($message) ? $message : ResponseMessageEnums::SERVER_ERROR;
    }

    /**
     * @param Throwable $e
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    protected function getStatusCode(Throwable $e, Request $request): string
    {
        return $e->getCode() === 0 ? parent::render($request, $e)->getStatusCode() : $e->getCode();
    }
}
