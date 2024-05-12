<?php

namespace App\Helpers;

/**
 * Class ResponseHelper
 *
 * Helper class for generating success response.
 */
class ResponseHelper
{
    /**
     * Helper for returning success response
     *
     * @param mixed|null $data Callback Data yang akan dikirim
     * @param string $withMessage Pesan yang akan dimasukkan
     * @param int $code Status kode yang akan disisipkan ke dalam `response()`
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $data = null, string $withMessage = null, int $code = 200)
    {
        $response = collect([
            'code' => 200,
            'status' => 'success',
        ])->tap(function ($item) use ($data, $withMessage, $code) {
            if ($data) {
                $item->put('data', $data);
            }
            if ($withMessage) {
                $item->put('message', $withMessage);
            }
            if ($code) {
                $item->put('code', $code);
            }
        });

        return response()->json($response->toArray(), $code);
    }

    /**
     * Helper for returning error response
     *
     * @param mixed|null $data Callback Data yang akan dikirim
     * @param string $withMessage Pesan yang akan dimasukkan
     * @param int $code Status kode yang akan disisipkan ke dalam `response()`
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(mixed $data = null, string $withMessage = null, int $code = 500)
    {
        $response = collect([
            'code' => 500,
            'status' => 'error',
        ])->tap(function ($item) use ($data, $withMessage, $code) {
            if ($data) {
                $item->put('data', $data);
            }
            if ($withMessage) {
                $item->put('message', $withMessage);
            }
            if ($code) {
                $item->put('code', $code);
            }
        });

        return response()->json($response->toArray(), $code);
    }
}
