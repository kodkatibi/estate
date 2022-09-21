<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected array $map = [
        ValidationException::class => [
            'status' => [
                'code' => -1,
                'success' => false,
                'msg' => '',
            ],
            'errors' => 'stringify_validation_exception',
            'httpCode' => 422
        ],
        JWTException::class => [
            'status' => [
                'code' => -1,
                'success' => false,
                'msg' => 'Invalid token',
            ],
            'errors' => 'stringify_validation_exception',
            'httpCode' => 422
        ]
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response|JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse
    {
        $class = get_class($e);

        if (!isset($this->map[$class])) {
            return parent::render($request, $e);
        }

        $errors = [];
        if ($e instanceof ValidationException) {
            $messages = $e->validator->getMessageBag()->getMessages();
            foreach ($messages as $k => $message) {
                $errors[] = [
                    'label' => $k,
                    'msg' => value($message)
                ];
            }
        }

        $response = $this->map[$class];
        $data = $response['data'] ?? [];
        $status = $response['status'] ?? [];
        $httpCode = $e->getCode() === 0 ? $response['httpCode'] : $e->getCode();
        $httpCode = isset(Response::$statusTexts[$httpCode]) ? $httpCode : 422;
        $msg = $status['msg'] ?? $e->getMessage();
        if (is_callable($msg)) {
            $msg = $msg($e);
        }
        $status['msg'] = $msg;
        $exceptionResult = [
            'data' => $data,
            'status' => $status,
            'errors' => $errors
        ];

        return response()->json($exceptionResult, $httpCode);
    }
}
