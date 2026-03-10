<?php

namespace Skywalker\Support\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class     VerifyJsonRequest
 *
 * @author   Skywalker <skywalker@example.com>
 */
class VerifyJsonRequest
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Supported request method verbs.
     *
     * @var array<int, string>
     */
    protected $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array<int, string>|null  $methods
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $methods = null)
    {
        if ($this->isJsonRequestValid($request, $methods)) {
            return $next($request);
        }

        return $this->jsonErrorResponse();
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Validate json Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|array<int, string>|null  $methods
     * @return bool
     */
    protected function isJsonRequestValid(Request $request, $methods): bool
    {
        $methodsArray = $this->getMethods($methods);

        if (! in_array($request->method(), $methodsArray)) {
            return false;
        }

        return $request->isJson();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the error as json response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonErrorResponse(): JsonResponse
    {
        $data = [
            'status' => 'error',
            'code' => $statusCode = Response::HTTP_BAD_REQUEST,
            'message' => 'Request must be JSON',
        ];

        return new JsonResponse($data, $statusCode);
    }

    /**
     * Get request methods.
     *
     * @param  string|array<int, string>|null  $methods
     * @return array<int, string>
     */
    protected function getMethods($methods = null): array
    {
        $resolvedMethods = $methods ?? $this->methods;

        if (is_string($resolvedMethods)) {
            $resolvedMethods = [$resolvedMethods];
        }

        /** @var array<int, string> $resolvedMethods */
        return array_map(function ($method) {
            return strtoupper((string) $method);
        }, $resolvedMethods);
    }
}
