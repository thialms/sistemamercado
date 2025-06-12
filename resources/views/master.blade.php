<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="{{ asset('build/assets/app-aR9eIDDg.css') }}">
    <title>Mercado do Fernando</title>
    {{-- Adicionar um favicon de mercado --}}
    @vite('resources/css/app.css')
</head>
<body>
    <div>
        @yield('content')
    </div>
    
</body>
</html>