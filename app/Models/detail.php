<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_tahapan',
        'name',
        'desc',
        'status',
        'hasil',
        'tgl_kumpul',
    ];
}
