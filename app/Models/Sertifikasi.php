<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasUuids;
    
    protected $table = 'sertifikasi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggota',
        'sertifikasi',
        'tahun',
        'penyelenggara',
        'tingkat',
        'dokumen_sertifikasi',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
