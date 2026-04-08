<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public $timestamps = false;
    protected $table = 'feed';
    protected $primaryKey = 'feed_id';
    protected $fillable = [
    'name', 'feed_type', 'unit', 'quantity_in_stock', 'min_stock_level',
    ];
    public function feedingLogs() { return $this->hasMany(FeedingLog::class, 'feed_id', 'feed_id'); }
    public function getRouteKeyName(): string { return 'feed_id'; }
}
