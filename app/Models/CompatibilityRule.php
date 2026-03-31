<?php
// app/Models/CompatibilityRule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompatibilityRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'trigger_component_id', 'operator',
        'target_component_id', 'auto_select', 'block_configuration',
        'error_message', 'success_message', 'active'
    ];

    protected $casts = [
        'auto_select' => 'boolean',
        'block_configuration' => 'boolean',
        'active' => 'boolean'
    ];

    public function triggerComponent()
    {
        return $this->belongsTo(Component::class, 'trigger_component_id');
    }

    public function targetComponent()
    {
        return $this->belongsTo(Component::class, 'target_component_id');
    }

    public function check(array $selectedComponentIds)
    {
        $triggerSelected = in_array($this->trigger_component_id, $selectedComponentIds);
        
        if (!$triggerSelected) {
            return ['applies' => false];
        }

        $targetSelected = in_array($this->target_component_id, $selectedComponentIds);

        switch ($this->operator) {
            case 'requires':
                return [
                    'applies' => true,
                    'satisfied' => $targetSelected,
                    'message' => $targetSelected ? $this->success_message : $this->error_message,
                    'type' => $targetSelected ? 'success' : 'error',
                    'action' => $targetSelected ? null : 'add_requirement'
                ];

            case 'incompatible_with':
                return [
                    'applies' => true,
                    'satisfied' => !$targetSelected,
                    'message' => $targetSelected ? $this->error_message : $this->success_message,
                    'type' => $targetSelected ? 'error' : 'success',
                    'action' => $targetSelected ? 'remove_conflict' : null
                ];
        }

        return ['applies' => false];
    }
}