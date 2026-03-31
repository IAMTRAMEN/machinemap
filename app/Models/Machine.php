<?php
// app/Models/Machine.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'display_name', 'description', 'base_price', 
        'specifications', 'image_url', 'active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'base_price' => 'decimal:2',
        'active' => 'boolean'
    ];

    public function components()
    {
        return $this->belongsToMany(Component::class, 'machine_component')
                    ->withPivot('compatible', 'notes')
                    ->withTimestamps();
    }

    public function compatibleComponents()
    {
        return $this->components()->wherePivot('compatible', true);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}