<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class AllWeeksPlayedException extends Exception {

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $previous);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->message], Response::HTTP_BAD_REQUEST);
    }
}
