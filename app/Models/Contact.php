<?php
// app/Models/Contact.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id', 'first_name', 'last_name', 'email', 'phone',
        'job_title', 'department', 'is_primary', 'decision_maker', 'preferences'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'decision_maker' => 'boolean',
        'preferences' => 'array'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}