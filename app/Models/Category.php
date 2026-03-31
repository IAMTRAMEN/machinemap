<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug', 
        'description',
        'order'
    ];

    // Relationship with components
    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Helper methods
    public function getComponentsCountAttribute()
    {
        return $this->components()->count();
    }



    // Auto-generate slug when name is set
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }
}