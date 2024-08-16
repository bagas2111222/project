<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'no_po',
        'tanggal_po',
        'perusahaan_id',
        'vendor_id',
        'start_date',
        'deadline',
        'complasion_date',
        'status',
    ];
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function vendor()
    {
        return $this->belongsTo(vendor::class);
    }

    public function tahapan()
    {
        return $this->hasMany(Tahapan::class, 'id_project');
    }
    public function struktur()
    {
        return $this->hasMany(Struktur::class, 'id_project');
    }
}
