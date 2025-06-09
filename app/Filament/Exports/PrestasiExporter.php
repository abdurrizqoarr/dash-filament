<?php

namespace App\Filament\Exports;

use App\Models\Prestasi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PrestasiExporter extends Exporter
{
    protected static ?string $model = Prestasi::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('anggota.nama_anggota')
                ->label('Nama Anggota'),
            ExportColumn::make('anggota.ranting.nama_ranting')
                ->label('Nama Ranting'),
            ExportColumn::make('prestasi'),
            ExportColumn::make('tahun'),
            ExportColumn::make('tingkat'),
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
