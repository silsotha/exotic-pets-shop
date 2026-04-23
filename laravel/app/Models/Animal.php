<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    public $timestamps = false;
    protected $table = 'animals';
    protected $primaryKey = 'animal_id';

    protected $fillable = [
        'species_id',
        'supplier_id',
        'nickname',
        'sex',
        'birth_date',
        'arrival_date',
        'status',
        'purchase_price',
        'sale_price',
        'cites_certificate',
        'photo_url',
    ];

    protected $casts = [
        'birth_date'   => 'date',
        'arrival_date' => 'date',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id', 'species_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
    public function vetRecords()
    {
        return $this->hasMany(VetRecord::class, 'animal_id', 'animal_id');
    }
    public function sale()
    {
        return $this->hasOne(Sale::class, 'animal_id', 'animal_id');
    }
    public function feedingLog()
    {
        return $this->hasMany(FeedingLog::class, 'animal_id', 'animal_id');
    }
    public function getRouteKeyName(): string
    {
        return 'animal_id';
    }
    public function getArrivalDateFormattedAttribute(): string
    {
        return $this->arrival_date->format('d.m.Y');
    }
    public function getBirthDateFormattedAttribute(): ?string
    {
        return $this->birth_date?->format('d.m.Y');
    }
}