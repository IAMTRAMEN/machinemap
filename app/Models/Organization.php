<?php
// app/Models/Organization.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'organization_type_id',
        'code',
        'legal_name',
        'tax_number',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'status',
        'custom_fields'
    ];

    protected $casts = [
        'custom_fields' => 'array'
    ];

    // ADD THE MISSING ACTIVE SCOPE
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id');
    }

    // Add relationship management relationships
    public function outgoingRelationships(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'from_organization_id');
    }

    public function incomingRelationships(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'to_organization_id');
    }

    public function providerSpecializations(): HasMany
    {
        return $this->hasMany(ProviderSpecialization::class);
    }

    public function partnerServices(): HasMany
    {
        return $this->hasMany(PartnerService::class);
    }

    // FIXED: Use 'type' instead of 'relationshipType'
    public function getCustomerRelationships()
    {
        return $this->outgoingRelationships()->whereHas('type', function($q) {
            $q->where('category', 'customer');
        });
    }

    // FIXED: Use 'type' instead of 'relationshipType'
    public function getProviderRelationships()
    {
        return $this->outgoingRelationships()->whereHas('type', function($q) {
            $q->where('category', 'provider');
        });
    }

    // FIXED: Use 'type' instead of 'relationshipType'
    public function getPartnerRelationships()
    {
        return $this->outgoingRelationships()->whereHas('type', function($q) {
            $q->where('category', 'partner');
        });
    }

    // FIXED: Method name was different - changed to match usage
    public function isPreferredSupplierFor($componentCategoryId)
    {
        return $this->providerSpecializations()
            ->where('component_category_id', $componentCategoryId)
            ->where('preferred_supplier', true)
            ->exists();
    }

    // ADD THIS METHOD IF IT'S BEING USED SOMEWHERE
    
}