<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Illuminate\Http\JsonResponse;

class JsonErrorResponse extends JsonResponse
{
    public function __construct($headers = [], $options = 0)
    {
        parent::__construct(['error' => 'Something went wrong'], 500, $headers, $options, false);
    }
}
