

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar - MyBlog</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Daftar Akun Baru</h2>

    <form action="/register" method="POST" class="space-y-5">
      <!-- Username -->
      <div>
        <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Konfirmasi Password -->
      <div>
        <label for="confirm_password" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Tombol Register -->
      <button type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
        Daftar
      </button>
    </form>

    <!-- Link ke login -->
    <p class="mt-6 text-center text-sm text-gray-600">
      Sudah punya akun?
      <a href="login.php" class="text-blue-600 hover:underline">Login di sini</a>
    </p>
  </div>

</body>
</html>
