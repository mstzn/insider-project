<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamCountIsNotEvenException extends Exception {
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->message], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
