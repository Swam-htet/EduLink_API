<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiException extends Exception
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var int
     */
    protected $statusCode = 400;

    /**
     * Create a new API exception instance.
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @param \Throwable|null $previous
     * @return void
     */
    public function __construct(string $message = 'Bad Request', int $statusCode = 400, array $errors = [], \Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);

        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    /**
     * Get the errors array.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $this->getMessage(),
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->statusCode);
    }
}
