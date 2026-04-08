<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    protected $fillable = [
    'full_name', 'phone', 'email', 'passport_data', 'registration_date',
    ];
    public function sales() { return $this->hasMany(Sale::class, 'client_id', 'client_id'); }
    public function getRouteKeyName(): string { return 'client_id'; }
}
