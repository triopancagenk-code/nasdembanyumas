<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DprtOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dprt_id',
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

    public function dprt(): BelongsTo
    {
        return $this->belongsTo(Dprt::class, 'dprt_id');
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
