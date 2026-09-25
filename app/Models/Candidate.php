<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'nama',
        'tingkat',
        'dapil',
        'nomor_urut',
        'jenis_kelamin',
        'foto',
        'jabatan',
        'basis_wilayah',
        'target_suara',
        'suara_masuk',
        'status',
        'slogan',
        'phone',
        'pendidikan_terakhir',
    ];

    protected $casts = [
        'nomor_urut' => 'integer',
        'target_suara' => 'integer',
        'suara_masuk' => 'integer',
    ];

    /**
     * Get percentage of target achieved.
     */
    public function getPercentageAttribute(): float
    {
        if ($this->target_suara <= 0) {
            return 0.0;
        }
        return min(100.0, round(($this->suara_masuk / $this->target_suara) * 100, 1));
    }
}
