<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Perizinan Santri')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
    <style>
        .ts-wrapper .ts-control {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 1rem !important;
            padding: 10px 16px !important;
            background: #f9fafb !important;
            font-size: 0.875rem !important;
            box-shadow: none !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, .12) !important;
            background: #fff !important;
        }

        .ts-dropdown {
            border-radius: 1rem !important;
            border: 1.5px solid #d1fae5 !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
            margin-top: 6px !important;
        }

        .ts-dropdown .option.active {
            background: #ecfdf5 !important;
            color: #065f46 !important;
        }

        .ts-dropdown .option:hover {
            background: #f0fdf4 !important;
            color: #047857 !important;
        }
    </style>
</head>

<body class="bg-gray-100">

    {{-- Konten penuh dari masing-masing page, tanpa wrapper di sini --}}
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')

</body>

</html>