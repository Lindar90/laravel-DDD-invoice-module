<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use App\Infrastructure\Database\Entities\ProductEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProductLineEntity extends Model
{
    public $incrementing = false;

    protected $table = 'invoice_product_lines';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'quantity',
        'invoice_id',
        'product_id',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(InvoiceEntity::class, 'invoice_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductEntity::class, 'product_id');
    }
}
