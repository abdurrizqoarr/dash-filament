<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Auth\Login;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;

class AdminLogin extends Login
{
    protected static string $view = 'filament.admin.pages.admin-login';

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label("Username")
            ->placeholder('Enter your username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => 'Username atau password yang Anda masukkan salah.'
        ]);
    }

    public function getTitle(): string
    {
        return 'Login Admin';
    }

    public function getHeading(): string
    {
        return 'Silakan Masuk ke Akun Admin Anda';
    }
}
