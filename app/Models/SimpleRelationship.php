<?php
// app/Models/SimpleRelationship.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleRelationship extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone', 
        'email',
        'description',
        'relationship_type',
        'status',
        'company',
        'position',
        'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'array'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->where('relationship_type', 'customer');
    }

    public function scopeProviders($query)
    {
        return $query->where('relationship_type', 'provider');
    }

    public function scopePartners($query)
    {
        return $query->where('relationship_type', 'partner');
    }

    // Helper methods
    public function getDisplayNameAttribute()
    {
        return $this->company ? "{$this->name} - {$this->company}" : $this->name;
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'customer' => 'bg-primary',
            'provider' => 'bg-success', 
            'partner' => 'bg-info',
            'other' => 'bg-secondary'
        ];

        return $badges[$this->relationship_type] ?? 'bg-secondary';
    }
}