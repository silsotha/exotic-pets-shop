<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    public $timestamps = false;
    protected $table = 'species';
    protected $primaryKey = 'species_id';
    protected $fillable = [
        'name',
        'class',
        'habitat',
        'description',
        'care_level',
        'temp_min',
        'temp_max',
        'humidity_min',
        'humidity_max',
        'quarantine_days',
    ];

    public function getCareLevelLabelAttribute(): string
    {
        return match ($this->care_level) {
            'beginner' => 'Подходит новичкам',
            'intermediate' => 'Средняя',
            'advanced' => 'Для опытных владельцев',
            default => 'Не указано',
        };
    }

    public function animals() { return $this->hasMany(Animal::class, 'species_id', 'species_id'); }
    public function getRouteKeyName(): string { return 'species_id'; }
}
