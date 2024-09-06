<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'periode_penjualan',
        'jumlah_penjualan'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
