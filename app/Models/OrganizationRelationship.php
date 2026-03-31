<?php
// app/Models/OrganizationRelationship.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationRelationship extends Model
{
    protected $fillable = [
        'from_organization_id', 'to_organization_id', 'relationship_type_id',
        'description', 'relationship_start', 'relationship_end', 'status',
        'terms', 'performance_score'
    ];

    protected $casts = [
        'terms' => 'array',
        'relationship_start' => 'date',
        'relationship_end' => 'date',
        'performance_score' => 'decimal:2'
    ];

    public function fromOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'from_organization_id');
    }

    public function toOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'to_organization_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(RelationshipType::class, 'relationship_type_id');
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(RelationshipInteraction::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(RelationshipContract::class);
    }

    // ADD THESE MISSING SCOPES:
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->whereHas('type', function($q) {
            $q->where('category', 'customer');
        });
    }

    public function scopeProviders($query)
    {
        return $query->whereHas('type', function($q) {
            $q->where('category', 'provider');
        });
    }

    public function scopePartners($query)
    {
        return $query->whereHas('type', function($q) {
            $q->where('category', 'partner');
        });
    }
}