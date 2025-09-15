<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResponseHelper
{
    public static function jsonResponse($success, $message, $data, $statusCode) : jsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Balikkan respons JSON yang seragam.
     *
     * $meta dipakai untuk info tambahan (mis. pagination).
     */
    public static function jsonResponseAll(
        bool $success,
        string $message,
        mixed $data = null,
        int $statusCode = 200,
        ?array $meta = null
    ): JsonResponse {
        // Jika yang dikirim adalah paginator, ekstrak jadi data + meta
        if ($data instanceof LengthAwarePaginator) {
            $meta = array_merge($meta ?? [], [
                'mode'         => 'paginated',
                'current_page' => $data->currentPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'last_page'    => $data->lastPage(),
            ]);
            $data = $data->items(); // hanya itemnya, bukan struktur lengkap paginator
        }

        $payload = [
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ];

        if ($meta !== null) {
            $payload['meta'] = $meta;
        }

        return response()->json($payload, $statusCode);
    }
}
