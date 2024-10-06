<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'periode',
        'value',
        'alpha',
        'mape'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productCategory()
    {
        return $this->hasOneThrough(ProductCategory::class, Product::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function voteCount()
    {
        return [
            'up' => $this->votes()->where('is_upvote', true)->count(),
            'down' =>
                $this->votes()->where('is_upvote', false)->count()
        ];
    }
}
