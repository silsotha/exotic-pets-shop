<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingLog extends Model
{
    public $timestamps = false;
    protected $table = 'feeding_log';
    protected $primaryKey = 'log_id';
    protected $fillable = [
        'animal_id',
        'feed_id',
        'employee_id',
        'feeding_date',
        'quantity',
        'notes',
    ];
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'animal_id');
    }
    public function feed()
    {
        return $this->belongsTo(Feed::class, 'feed_id', 'feed_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
    public function getRouteKeyName(): string { return 'log_id'; }
}
