<?php
// app/Models/RelationshipType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RelationshipType extends Model
{
    protected $fillable = ['name', 'category', 'description', 'metadata', 'active'];
    
    protected $casts = [
        'metadata' => 'array',
        'active' => 'boolean'
    ];

    public function relationships(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'relationship_type_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}