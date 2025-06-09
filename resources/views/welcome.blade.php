<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/homepage.css')
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="left">
                <h1>SIMANIES PSHT</h1>
                <p>Sistem Informasi Manajemen Administrasi Elektronik Persaudaraan Setia Hati Terate</p>
                <a href="{{ route('filament.anggota.auth.login') }}">Login Sebagai Anggota</a>
            </div>
            <div class="right"></div>
        </div>
    </div>
</body>

</html>
