<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    public $timestamps = false;

    protected $table = 'feed';
    protected $primaryKey = 'feed_id';

    protected $fillable = [
        'name',
        'feed_type',
        'description',
        'purpose',
        'animal_classes',
        'unit',
        'quantity_in_stock',
        'min_stock_level',
        'animal_groups',
        'rodent_stage',
        'prey_weight_min',
        'prey_weight_max',
    ];

    protected $casts = [
        'animal_classes' => 'array',
        'quantity_in_stock' => 'integer',
        'min_stock_level' => 'integer',
        'prey_weight_min' => 'integer',
        'prey_weight_max' => 'integer',
        'animal_groups' => 'array',
    ];

    public function stockMovements(): HasMany
    {
        return $this->hasMany(FeedStockMovement::class, 'feed_id', 'feed_id')->latest();
    }

    public function getPublicStockStatusAttribute(): string
    {
        if ((int) $this->quantity_in_stock <= 0) return 'out';
        if ((int) $this->quantity_in_stock <= (int) $this->min_stock_level) return 'low';
        return 'available';
    }

    public function getPublicStockLabelAttribute(): string
    {
        return match ($this->public_stock_status) {
            'out' => 'Нет в наличии',
            'low' => 'Осталось мало',
            default => 'В наличии',
        };
    }

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(
            Species::class,
            'feed_species',
            'feed_id',
            'species_id',
            'feed_id',
            'species_id'
        );
    }

    public function feedingLogs(): HasMany
    {
        return $this->hasMany(FeedingLog::class, 'feed_id', 'feed_id');
    }

    public function getRouteKeyName(): string
    {
        return 'feed_id';
    }

    public function getRodentStageLabelAttribute(): ?string
    {
        return match ($this->rodent_stage) {
            'pinkie' => 'Голыш',
            'fuzzy' => 'Опушок',
            'hopper' => 'Бегунок',
            'adult' => 'Взрослая мышь',
            default => null,
        };
    }

    public function getPreyWeightLabelAttribute(): ?string
    {
        if ($this->prey_weight_min === null && $this->prey_weight_max === null) {
            return null;
        }

        if ($this->prey_weight_min !== null && $this->prey_weight_max !== null) {
            return $this->prey_weight_min === $this->prey_weight_max
                ? $this->prey_weight_min . ' г'
                : $this->prey_weight_min . '–' . $this->prey_weight_max . ' г';
        }

        return ($this->prey_weight_min ?? $this->prey_weight_max) . ' г';
    }
}
