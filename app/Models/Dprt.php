<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dprt extends Model
{
    use HasFactory;

    protected $fillable = [
        'dpc_id',
        'kecamatan_name',
        'desa_name',
        'type',
        'ketua_name',
        'phone',
        'status',
        'total_kader',
    ];

    public function dpc(): BelongsTo
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }
}
