<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kemahasiswaan FMIPA UHO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
        <!-- 🧿 Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/Untitled.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/Untitled.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/Untitled.png') }}">
    <meta name="theme-color" content="#800000">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen bg-gray-200 p-4 sm:p-6 md:p-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md">
            <div class="text-center mb-6">
                <img src="/assets/img/untitled.png" alt="Logo"
                    class="mx-auto mb-4 w-16 h-16 sm:w-20 sm:h-20">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Dasbor Admin FMIPA UHO</h1>
                <p class="text-sm sm:text-base text-gray-500">Silakan login untuk melanjutkan</p>
            </div>

            {{-- Form akan di-handle oleh route login Laravel --}}
            <form id="loginForm" method="POST" action="{{ route('auth.login') }}">
                @csrf
                {{-- Pesan error akan kita handle via JavaScript (alert) --}}
                {{-- @error('username')
                    <p class="bg-red-500 py-2 px-3 text-center text-white mb-2">{{ $message }}</p>
                @enderror --}}
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        {{-- 'name' attribute penting untuk form submission --}}
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="mt-1 w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900"
                            placeholder="Username" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900"
                            placeholder="*********" required>
                    </div>
                    <button type="submit"
                        class="w-full bg-red-900 text-white py-2 px-4 rounded-md text-sm sm:text-base font-semibold hover:bg-red-950 transition-colors">Login</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Fungsi ini akan memproses jawaban dari server dan mengirim sinyal ke Flutter
        function handleLoginResponse(dataFromServer) {
            if (dataFromServer.success) {
                // Cek apakah 'jembatan' bernama 'flutterApp' ada
                if (window.flutterApp) {
                    // Kirim pesan berisi ID user ke Flutter
                    window.flutterApp.postMessage(dataFromServer.user.id.toString());
                }

                // Arahkan ke halaman dashboard setelah sukses
                window.location.href = '/dashboard';
            } else {
                // Tampilkan pesan error jika login gagal
                alert(dataFromServer.message || 'Terjadi kesalahan saat login.');
            }
        }

        // Kode ini berjalan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');

            loginForm.addEventListener('submit', function (event) {
                // 1. Cegah form dari me-refresh halaman
                event.preventDefault();

                const formData = new FormData(loginForm);

                // 2. Kirim data ke server Laravel menggunakan Fetch API
                fetch("{{ route('auth.login') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        // Kita tidak set Content-Type, biarkan browser menentukannya untuk FormData
                        'X-CSRF-TOKEN': formData.get('_token'),
                    },
                    body: formData,
                })
                .then(response => response.json()) // Ubah jawaban server menjadi JSON
                .then(dataFromServer => {
                    // 3. Setelah dapat jawaban, panggil fungsi handleLoginResponse
                    handleLoginResponse(dataFromServer);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                });
            });
        });
    </script>
</body>

</html>
