<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User ReadSpace')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- SIDEBAR -->
    <x-sidebar-user />

    <!-- HEADER (Modified for User if needed, or reuse Admin Header) -->
    <!-- Reusing Admin Header for now as it dynamically shows User Name -->
    <x-header />


    <!-- MAIN CONTENT -->
    <main class="min-h-screen p-6 ml-0 md:ml-72 transition-all duration-300">

        @yield('content')
    </main>

</body>
</html>
