<?php

namespace App\Helpers;

use App\Enums\ResponseMessageEnums;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Api
{
    /**
     * Returns a JSON response for a successful request.
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function ok(mixed $data = null, string $message = ResponseMessageEnums::OK): JsonResponse
    {
        return self::successSchema(Response::HTTP_OK, $data, $message);
    }


    /**
     * Returns a JSON response for a resource created.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function created(mixed $data = null, string $message = ResponseMessageEnums::CREATED) : JsonResponse
    {
        return self::successSchema(Response::HTTP_CREATED, $data, $message);
    }

    /**
     * Returns a JSON response for a resource accepted.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function accepted(mixed $data = null, string $message = ResponseMessageEnums::ACCEPTED): JsonResponse
    {
        return self::successSchema(Response::HTTP_ACCEPTED, $data, $message);
    }

    /**
     * Returns a JSON response with no content.
     *
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Returns a JSON response for a bad request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function badRequest(mixed $errors = null, string $message = ResponseMessageEnums::BAD_REQUEST
    ): JsonResponse {
        return self::errorSchema(Response::HTTP_BAD_REQUEST, $errors, $message);
    }

    /**
     * Returns a JSON response for an unauthorized request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized(mixed $errors = null, string $message = ResponseMessageEnums::UNAUTHORIZED
    ): JsonResponse {
        return self::errorSchema(Response::HTTP_UNAUTHORIZED, $errors, $message);
    }

    /**
     * Returns a JSON response for a forbidden request.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function forbidden(mixed $errors = null, string $message = ResponseMessageEnums::FORBIDDEN
    ): JsonResponse {
        return self::errorSchema(Response::HTTP_FORBIDDEN, $errors, $message);
    }

    /**
     * Returns a JSON response for a not found request.
     *
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function notFound(mixed $errors = null, $message = ResponseMessageEnums::NOT_FOUND): JsonResponse
    {
        return self::errorSchema(Response::HTTP_NOT_FOUND, $errors, $message);
    }

    /**
     * Returns a JSON response for a request that is not acceptable.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function unprocessableEntity(
        mixed $errors = null,
        string $message = ResponseMessageEnums::INVALID_PAYLOAD
    ): JsonResponse {
        return self::errorSchema(Response::HTTP_UNPROCESSABLE_ENTITY, $errors, $message);
    }

    /**
     * Returns a JSON response for error handling.
     *
     * @param integer $statusCode
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function dynamic(
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        mixed $errors = null,
        string $message = ResponseMessageEnums::SERVER_ERROR
    ): JsonResponse {
       return self::errorSchema($statusCode, $errors, $message);
    }

    /**
     * @param $code
     * @param $data
     * @param $message
     * @return JsonResponse
     */
    private static function successSchema($code, $data, $message): JsonResponse
    {
        return response()->json([
            'status' => (int) $code,
            'message' => (string) $message,
            'data' => $data,
            'execution' => self::getExecutionTime(),
        ], (int) $code);
    }

    /**
     * @param $code
     * @param $errors
     * @param $message
     * @return JsonResponse
     */
    private static function errorSchema($code, $errors, $message): JsonResponse
    {
        return response()->json([
            'status' => (int) $code,
            'message' => (string) $message,
            'errors' => $errors,
            'execution' => self::getExecutionTime(),
        ], (int) $code);
    }

    /**
     * @return string
     */
    private static function getExecutionTime(): string
    {
        return number_format(((microtime(true) - LARAVEL_START) * 1000), 0).' ms';
    }
}
