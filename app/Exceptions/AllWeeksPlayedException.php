<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllWeeksPlayedException extends Exception {
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->message], Response::HTTP_BAD_REQUEST);
    }
}
