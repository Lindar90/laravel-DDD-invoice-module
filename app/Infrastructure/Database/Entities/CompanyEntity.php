<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyEntity extends Model
{
    public $incrementing = false;

    protected $table = 'companies';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];
}
