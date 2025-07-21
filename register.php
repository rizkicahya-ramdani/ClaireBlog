<?php
include __DIR__ . '/connection.php'; // sesuaikan path koneksi

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username         = trim($_POST['username']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi tidak cocok.'); window.history.back();</script>";
        exit;
    }

    // Cek apakah username atau email sudah ada
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username atau email sudah digunakan.'); window.history.back();</script>";
        exit;
    }

    // Hash password dengan metode bawaan PHP yang aman
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $default_picture = 'uploads/default.png';

    $stmt = $connection->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $default_picture);

    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal mendaftar.'); window.history.back();</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar - MyBlog</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Daftar Akun Baru</h2>

    <form action="" method="POST" class="space-y-5">
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
