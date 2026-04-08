<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps = false;
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'name', 'contact_person', 'phone', 'email', 'license_number',
    ];

    public function animals() { return $this->hasMany(Animal::class, 'supplier_id', 'supplier_id'); }
    public function getRouteKeyName(): string { return 'supplier_id'; }
}
