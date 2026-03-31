<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_number', 'machine_id', 'total_price', 'total_installation_time',
        'customer_name', 'customer_email', 'customer_company', 'customer_phone',
        'configuration_data', 'notes', 'status'
    ];

    protected $casts = [
        'configuration_data' => 'array'
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class, 'quote_components')
                    ->withPivot('unit_price', 'quantity', 'installation_time')
                    ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($quote) {
            if (empty($quote->quote_number)) {
                // Remove withTrashed() since we're not using soft deletes yet
                $count = static::count() + 1;
                $quote->quote_number = 'Q' . date('Ymd') . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
    
}