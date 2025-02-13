<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler {
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
    public function register() {
        $this->reportable(function (Throwable $e) {
            Log::error($e->getMessage(), $this->context());
        })->stop();
    }

    protected function context(): array {
        try {
            return array_filter([
                    'uri' => Auth::getRequest()->getRequestUri(),
                    'who' => Auth::guard()->getName() . ', ' . Auth::guard()->user()->fio
                // 'email' => optional(Auth::user())->email,
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }
}
