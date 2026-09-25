<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCountParty extends Model
{
    use HasFactory;

    protected $table = 'quick_count_parties';

    protected $fillable = [
        'party_name',
        'party_number',
        'color_hex',
        'total_suara',
        'kursi_dprd',
    ];

    protected $casts = [
        'party_number' => 'integer',
        'total_suara' => 'integer',
        'kursi_dprd' => 'integer',
    ];
}
