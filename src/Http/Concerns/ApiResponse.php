<?php

namespace Skywalker\Support\Http\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     */
    protected function apiSuccess($data, ?string $message = null, int $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  mixed  $errors
     */
    protected function apiError(string $message, int $code = Response::HTTP_BAD_REQUEST, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    /**
     * Return a no content JSON response.
     */
    protected function apiNoContent()
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return a created JSON response.
     *
     * @param  mixed  $data
     */
    protected function apiCreated($data, ?string $message = null)
    {
        return $this->apiSuccess($data, $message, Response::HTTP_CREATED);
    }
}
