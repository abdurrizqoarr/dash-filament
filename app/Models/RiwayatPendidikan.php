<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasUuids;

    protected $table = 'riwayat_pendidikan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_anggota',
        'tingakt_pendidikan',
        'nama_instansi',
        'ijazah',
        'tahun_lulus',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id');
    }
}
