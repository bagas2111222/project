<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tahapan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_project',
        'tanggal_start',
        'deadline',
        'status',
        'persen',
        'tgl_actual',
        'hasil_tahapan',
        'tgl_hasil'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class,'id_project');
    }
}
