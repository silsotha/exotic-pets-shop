<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedStockMovement extends Model
{
    protected $fillable = [
        'feed_id', 'employee_id', 'operation_type', 'quantity_change', 'notes',
    ];

    protected $casts = ['quantity_change' => 'integer'];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class, 'feed_id', 'feed_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
