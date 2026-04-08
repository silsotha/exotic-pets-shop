<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VetRecord extends Model
{
    protected $primaryKey = 'record_id';
    protected $table = 'vet_records';
    public $timestamps = false;

    protected $fillable = [
        'animal_id', 'vet_id', 'record_date',
        'record_type', 'diagnosis', 'treatment', 'result',
    ];

    public function getRouteKeyName(): string
    {
        return 'record_id';
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'animal_id');
    }

    public function vet()
    {
        return $this->belongsTo(Employee::class, 'vet_id', 'employee_id');
    }
}