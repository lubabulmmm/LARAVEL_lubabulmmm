<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    
    protected $fillable = [
        'nama_pasien',
        'alamat',
        'no_telepon',
        'rumah_sakit_id'
    ];

    // Relationship with RumahSakit
    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'rumah_sakit_id');
    }
}
