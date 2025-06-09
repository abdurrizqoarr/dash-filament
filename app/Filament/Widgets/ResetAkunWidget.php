<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResetAkunWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static string $view = 'filament.widgets.reset-akun-widget';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Baru')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label('Email Baru')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Password Baru')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->minLength(6)
                    ->maxLength(240),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();

            $user = Auth::user();
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->password = $formData['password'];
            $user->save();

            // Clear the form
            $this->form->fill([]);

            Notification::make()
                ->title('Ganti Akun Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Exception $e) {
            Log::error('ResetAkunWidget submit error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            Notification::make()
                ->title('Terjadi kesalahan saat mengganti akun')
                ->duration(3000)
                ->danger()
                ->body('Silakan coba lagi atau hubungi admin.')
                ->send();
        }
    }
}
