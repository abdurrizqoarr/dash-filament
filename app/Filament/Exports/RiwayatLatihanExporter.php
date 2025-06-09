<?php

namespace App\Filament\Exports;

use App\Models\RiwayatLatihan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RiwayatLatihanExporter extends Exporter
{
    protected static ?string $model = RiwayatLatihan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('anggota.nama_anggota')
                ->label('Nama Anggota'),
            ExportColumn::make('anggota.ranting.nama_ranting')
                ->label('Nama Ranting'),
            ExportColumn::make('tingkat'),
            ExportColumn::make('rayon'),
            ExportColumn::make('penyelenggara'),
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
