<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = $_POST['password'] ?? '';

    if (!empty($username_or_email) && !empty($password)) {
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username_or_email, $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['profile_picture'] = $user['profile_picture'];

                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Password salah'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Akun tidak ditemukan'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Mohon isi semua field'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Login</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">ClaireBlog</h2>
    <form method="POST" class="space-y-5">
      
      <div>
        <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Username atau Email</label>
        <input type="text" id="username" name="username" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center">
          <input type="checkbox" class="mr-2" name="remember" />
          Ingat saya
        </label>
        <a href="#" class="text-blue-600 hover:underline">Lupa password?</a>
      </div>

      <button type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
        Login
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Belum punya akun?
      <a href="register.php" class="text-blue-600 hover:underline">Daftar sekarang</a>
    </p>
  </div>

</body>
</html>
