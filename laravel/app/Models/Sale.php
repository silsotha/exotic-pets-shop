<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = false;
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $fillable = [
    'animal_id', 'client_id', 'employee_id',
    'sale_date', 'total_price', 'payment_method', 'contract_number',
    ];
    public function animal()   { return $this->belongsTo(Animal::class, 'animal_id', 'animal_id'); }
    public function client()   { return $this->belongsTo(Client::class, 'client_id', 'client_id'); }
    public function employee() { return $this->belongsTo(Employee::class, 'employee_id', 'employee_id'); }
    public function getRouteKeyName(): string { return 'sale_id'; }
}
