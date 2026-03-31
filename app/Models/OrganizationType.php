<?php
// app/Models/OrganizationType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationType extends Model
{
    protected $fillable = ['name', 'description', 'active'];
    
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}