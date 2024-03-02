<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductEntity extends Model
{
    public $incrementing = false;

    protected $table = 'products';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'price',
        'currency',
    ];
}
