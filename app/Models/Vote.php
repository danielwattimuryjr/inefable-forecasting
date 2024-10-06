<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'forecast_id', 'is_upvote'];

    protected function casts(): array
    {
        return [
            'is_upvote' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
