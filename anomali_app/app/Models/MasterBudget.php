<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan',
        'jumlah_hk',
        'budget_bulan_rp',
    ];
}
