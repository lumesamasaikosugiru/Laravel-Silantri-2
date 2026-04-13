<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Izin Santri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl p-6">
            @yield('content')
        </div>
    </div>

</body>

</html>