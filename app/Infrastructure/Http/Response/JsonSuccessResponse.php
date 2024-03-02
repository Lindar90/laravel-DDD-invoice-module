<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Illuminate\Http\JsonResponse;

class JsonSuccessResponse extends JsonResponse
{
    public function __construct($data = null, $headers = [], $options = 0)
    {
        parent::__construct(['data' => $data], 200, $headers, $options, false);
    }
}
