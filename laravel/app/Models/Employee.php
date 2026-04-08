<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'full_name',
        'role',
        'phone',
        'hire_date',
    ];
    public function vetRecords()  { return $this->hasMany(VetRecord::class, 'vet_id', 'employee_id'); }
    public function sales()       { return $this->hasMany(Sale::class, 'employee_id', 'employee_id'); }
    public function feedingLogs() { return $this->hasMany(FeedingLog::class, 'employee_id', 'employee_id'); }
    public function getRouteKeyName(): string { return 'employee_id'; }
}
