<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'limit',
        'used',
        'renew_date',
    ];

    protected $casts = [
        'renew_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasReachedLimit(): bool
    {
        return $this->used >= $this->limit;
    }

    public function getRemainingUsage(): int
    {
        return max(0, $this->limit - $this->used);
    }
}
