<?php
// app/Models/Component.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'code', 'description', 'price', 
        'installation_time', 'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_component')
                    ->withPivot('compatible', 'notes')
                    ->withTimestamps();
    }

    public function triggerRules()
    {
        return $this->hasMany(CompatibilityRule::class, 'trigger_component_id');
    }

    public function targetRules()
    {
        return $this->hasMany(CompatibilityRule::class, 'target_component_id');
    }
    
}