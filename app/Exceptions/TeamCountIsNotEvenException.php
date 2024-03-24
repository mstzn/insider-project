<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class TeamCountIsNotEvenException extends Exception {
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY, $previous);
    }
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->message], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
