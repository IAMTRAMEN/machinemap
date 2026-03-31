<?php
// app/Models/RelationshipInteraction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelationshipInteraction extends Model
{
    protected $fillable = [
        'organization_relationship_id', 'user_id', 'interaction_type',
        'subject', 'description', 'interaction_date', 'participants',
        'outcomes', 'next_steps', 'follow_up_date'
    ];

    protected $casts = [
        'interaction_date' => 'datetime',
        'follow_up_date' => 'datetime',
        'participants' => 'array',
        'outcomes' => 'array'
    ];

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(OrganizationRelationship::class, 'organization_relationship_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}