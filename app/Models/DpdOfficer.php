<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpdOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'name',
        'photo',
        'phone',
        'sk_number',
        'sort_order',
        'status',
    ];
}
