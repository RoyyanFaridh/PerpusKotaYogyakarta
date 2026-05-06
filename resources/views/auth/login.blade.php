<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-2xl flex overflow-hidden w-[800px]">

        <!-- LEFT SIDE -->
        <div class="w-1/2 text-white p-10 flex flex-col justify-center"
             style="background-color: #04448D;">
            <h1 class="text-3xl font-bold mb-4">Admin Panel</h1>
            <p class="text-sm opacity-90">
                Selamat datang di sistem perpustakaan. Silakan login untuk melanjutkan.
            </p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-1/2 p-10">
            <h2 class="text-2xl font-semibold mb-6 text-gray-700">Login</h2>

            <form method="POST" action="#">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800"
                        placeholder="admin@email.com">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800"
                        placeholder="********">
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-2 rounded-lg text-white font-semibold"
                    style="background-color: #04448D;">
                    Login
                </button>
            </form>
        </div>

    </div>
</div>

</body>
</html>