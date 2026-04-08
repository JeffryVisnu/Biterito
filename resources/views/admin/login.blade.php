<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Biterito</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center" style="font-family: 'Poppins', sans-serif;">

<div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <p class="text-4xl mb-2">🌯</p>
        <h1 class="text-2xl font-bold text-gray-800">Biterito Admin</h1>
        <p class="text-gray-500 text-sm mt-1">Masuk ke dashboard admin</p>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf
        <div class="mb-4">
            <label class="text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" placeholder="admin@biterito.com"
                class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-600">Password</label>
            <input type="password" name="password" placeholder="••••••••"
                class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <button type="submit"
            class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
            Masuk
        </button>
    </form>
</div>

</body>
</html>