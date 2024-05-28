<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'start_at', 
        'expired_at', 
        'is_completed', 
        'company_id', 
        'user_id',
    ];

    public $timestamps = false;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class);
    }
}
