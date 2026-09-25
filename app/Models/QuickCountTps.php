<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCountTps extends Model
{
    use HasFactory;

    protected $table = 'quick_count_tps';

    protected $fillable = [
        'dapil',
        'kecamatan_name',
        'desa_name',
        'tps_number',
        'total_dpt',
        'suara_nasdem',
        'suara_sah',
        'suara_tidak_sah',
        'saksi_name',
        'saksi_phone',
        'c1_photo',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_dpt' => 'integer',
        'suara_nasdem' => 'integer',
        'suara_sah' => 'integer',
        'suara_tidak_sah' => 'integer',
    ];

    /**
     * Get percentage of NasDem votes in this TPS.
     */
    public function getNasdemPercentageAttribute(): float
    {
        if ($this->suara_sah <= 0) {
            return 0.0;
        }
        return round(($this->suara_nasdem / $this->suara_sah) * 100, 1);
    }
}
