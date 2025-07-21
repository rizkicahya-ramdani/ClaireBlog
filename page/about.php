<?php
session_start();
include '../connection.php';
include '../components/navbar.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Beranda</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">
<!-- Struktur Utama Halaman -->
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">

  <!-- Konten Utama -->
  <main class="flex-grow">
    <section class="max-w-4xl mx-auto px-6 py-12">
      <h1 class="text-4xl font-bold mb-6 text-center text-blue-700">Tentang Kami</h1>
      <p class="text-lg mb-4 text-justify leading-relaxed">
        Selamat datang di <strong>Blog-App</strong>, platform berbagi informasi dan artikel menarik dari berbagai kategori.
        Kami menyediakan tempat bagi pengguna untuk membaca dan berbagi pengetahuan yang bermanfaat, mulai dari teknologi,
        kesehatan, pendidikan, hingga lifestyle.
      </p>
      <p class="text-lg mb-4 text-justify leading-relaxed">
        Tujuan kami adalah menciptakan komunitas pembaca dan penulis yang terhubung, serta menghadirkan pengalaman membaca
        yang nyaman, ringan, dan inspiratif. Kami percaya bahwa setiap orang memiliki cerita dan wawasan yang bisa dibagikan.
      </p>
      <p class="text-lg text-justify leading-relaxed">
        Terima kasih telah mengunjungi Blog-App. Jangan ragu untuk membuat akun, menulis artikelmu sendiri, dan bergabung
        dalam komunitas kami!
      </p>
    </section>
  </main>

  <?php include '../components/footer.php'; ?>
</body>
