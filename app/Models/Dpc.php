<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dpc extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan_name',
        'dapil',
        'office_address',
        'ketua_name',
        'sekretaris_name',
        'bendahara_name',
        'phone',
        'sk_number',
        'status',
        'total_ranting',
        'total_kader',
        'total_suara',
        'target_suara',
    ];

    /**
     * Rasio perolehan suara per kader di kecamatan.
     */
    public function getRasioSuaraKaderAttribute(): float
    {
        if ($this->total_kader <= 0) {
            return 0.0;
        }
        return round($this->total_suara / $this->total_kader, 2);
    }

    /**
     * Persentase capaian target suara.
     */
    public function getPersenTargetAttribute(): float
    {
        if ($this->target_suara <= 0) {
            return 0.0;
        }
        return round(($this->total_suara / $this->target_suara) * 100, 1);
    }

    public function dprts(): HasMany
    {
        return $this->hasMany(Dprt::class, 'dpc_id');
    }
}
