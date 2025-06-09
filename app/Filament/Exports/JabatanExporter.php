<?php

namespace App\Filament\Exports;

use App\Models\Jabatan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class JabatanExporter extends Exporter
{
    protected static ?string $model = Jabatan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('anggota.nama_anggota')
                ->label('Nama Anggota'),
            ExportColumn::make('anggota.ranting.nama_ranting')
                ->label('Nama Ranting'),
            ExportColumn::make('lokasi_jabatan'),
            ExportColumn::make('jabatan'),
            ExportColumn::make('sk_jabatan'),
            ExportColumn::make('mulai_jabatan'),
            ExportColumn::make('akhir_jabatan'),
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
