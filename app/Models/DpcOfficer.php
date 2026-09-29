<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DpcOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dpc_id',
        'category',
        'title',
        'name',
        'photo',
        'phone',
        'sk_number',
        'instagram',
        'sort_order',
        'status',
    ];

    public function dpc(): BelongsTo
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }

    /**
     * Get clean Instagram URL.
     */
    public function getInstagramUrlAttribute(): string
    {
        if (empty($this->instagram)) {
            return 'https://instagram.com/nasdembanyumas';
        }

        $clean = trim($this->instagram);
        if (str_starts_with($clean, 'http://') || str_starts_with($clean, 'https://')) {
            return $clean;
        }

        $clean = ltrim($clean, '@');
        return 'https://instagram.com/' . $clean;
    }
}
