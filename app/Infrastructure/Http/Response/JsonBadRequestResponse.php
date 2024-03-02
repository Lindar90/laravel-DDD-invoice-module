<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Illuminate\Http\JsonResponse;

class JsonBadRequestResponse extends JsonResponse
{
    public function __construct(string $message, array $errors = [], $headers = [], $options = 0)
    {
        $data = [
            'data' => $message,
            'errors' => $errors,
        ];
        parent::__construct($data, 400, $headers, $options, false);
    }
}
