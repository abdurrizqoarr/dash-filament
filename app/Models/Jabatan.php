<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Jabatan extends Model
{
    use HasUuids;

    protected $table = 'jabatan';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggota',
        'lokasi_jabatan',
        'jabatan',
        'sk_jabatan',
        'mulai_jabatan',
        'akhir_jabatan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id');
    }
}
