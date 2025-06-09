<?php

namespace App\Filament\Exports;

use App\Models\Profile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProfileExporter extends Exporter
{
    protected static ?string $model = Profile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('anggota.nama_anggota')
                ->label('Nama Anggota'),
            ExportColumn::make('anggota.ranting.nama_ranting')
                ->label('Nama Ranting'),
            ExportColumn::make('nomer_induk_warga'),
            ExportColumn::make('nomer_induk_kependudukan'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('jenis_kelamin'),
            ExportColumn::make('status_pernikahan'),
            ExportColumn::make('alamat'),
            ExportColumn::make('jenis_pekerjaan'),
            ExportColumn::make('lembaga_instansi_bekerja'),
            ExportColumn::make('alamat_lembaga_instansi_bekerja'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor data jabatan Anda telah selesai dan sebanyak ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
