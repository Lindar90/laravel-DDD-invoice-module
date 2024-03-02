<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use App\Infrastructure\Database\Entities\CompanyEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceEntity extends Model
{
    public $incrementing = false;

    protected $table = 'invoices';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'number',
        'date',
        'due_date',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyEntity::class, 'company_id');
    }

    public function productLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLineEntity::class, 'invoice_id');
    }
}
