<?php

namespace App\Filament\Anggota\Pages;

use App\Models\Profile as ModelsProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'DASHBOARD';
    protected static string $view = 'filament.anggota.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $profile = ModelsProfile::where('id_anggota', $user->id)->first();

        if ($profile) {
            $this->form->fill($profile->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Section::make('Profil')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('nomer_induk_warga')
                            ->label('Nomer Induk Warga')
                            ->required()
                            ->minLength(2)
                            ->maxLength(240)
                            ->unique(ignoreRecord: true),

                        TextInput::make('nomer_induk_kependudukan')
                            ->label('NIK')
                            ->minLength(2)
                            ->maxLength(240)
                            ->nullable(),

                        TextInput::make('tempat_lahir')
                            ->minLength(2)
                            ->maxLength(240)
                            ->required(),

                        DatePicker::make('tanggal_lahir')
                            ->required(),

                        Select::make('jenis_kelamin')
                            ->options([
                                'Pria' => 'Pria',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

                        Select::make('status_pernikahan')
                            ->options([
                                'Belum Kawin' => 'Belum Kawin',
                                'Kawin' => 'Kawin',
                                'Duda' => 'Duda',
                                'Janda' => 'Janda',
                            ])
                            ->required(),

                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                ]),
            \Filament\Forms\Components\Section::make('Pekerjaan')
                ->schema([
                    Select::make('jenis_pekerjaan')
                        ->label('Jenis Pekerjaan')
                        ->options([
                            'Pedagang' => 'Pedagang',
                            'Wiraswasta' => 'Wiraswasta',
                            'Swasta' => 'Swasta',
                            'Karyawan Perusahaan' => 'Karyawan Perusahaan',
                            'ASN' => 'ASN',
                            'TNI' => 'TNI',
                            'POLRI' => 'POLRI',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->nullable(),

                    TextInput::make('lembaga_instansi_bekerja')
                        ->label('Lembaga / Instansi')
                        ->nullable(),

                    Textarea::make('alamat_lembaga_instansi_bekerja')
                        ->label('Alamat Instansi')
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ])->statePath('data');
    }

    public function submit()
    {
        $formData = $this->form->getState();
        try {
            $user = Auth::guard('anggota')->user();

            ModelsProfile::updateOrCreate(
                ['id_anggota' => $user->id],
                array_merge(
                    $formData,
                    ['id_anggota' => $user->id]
                )
            );

            Notification::make()
                ->title('Ganti Profile Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Log::error('Profile update error: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            Notification::make()
                ->title('Terjadi kesalahan saat menyimpan data')
                ->body('Mohon coba beberapa saat lagi')
                ->danger()
                ->duration(5000)
                ->send();
        }
    }
}
