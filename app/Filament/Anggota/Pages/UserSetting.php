<?php

namespace App\Filament\Anggota\Pages;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSetting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.anggota.pages.user-setting';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::guard('anggota')->user();

        $this->form->fill([
            'name' => $user->name,
            'username' => $user->username,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Section::make('User Setting')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),

                    TextInput::make('username')
                        ->label('Username')
                        ->required()
                        ->unique(ignorable: Auth::user()),

                    TextInput::make('password')
                        ->label('Password (Kosongkan jika tidak ingin mengubah)')
                        ->password()
                        ->minLength(6)
                        ->maxLength(240)
                        ->nullable(),
                ])
        ])->statePath('data');
    }

    public function submit(): void
    {
        try {
            $user = Auth::guard('anggota')->user();

            $data = $this->form->getState();

            $user->name = $data['name'];
            $user->username = $data['username'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            Notification::make()
                ->title('Ganti Akun Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->duration(5000)
                ->send();
        }
    }
}
