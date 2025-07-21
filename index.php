<?php 

include 'connection.php';
session_start(); 

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

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

  <link rel="stylesheet" href="style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include 'components/navbar.php'; ?>

  <section class="bg-blue-600 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h1 class="text-4xl font-bold mb-4">Selamat Datang di ClaireBlog</h1>
      <p class="text-lg">Temukan artikel menarik seputar teknologi, pemrograman, dan kehidupan digital.</p>
      <a href="#artikel" class="mt-6 inline-block bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100">Jelajahi Artikel</a>
    </div>
  </section>

  <section id="artikel" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-2xl font-bold mb-8 text-center">Artikel Terbaru</h2>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?coding,blog" alt="artikel" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">Cara Belajar Tailwind CSS untuk Pemula</h3>
            <p class="text-sm text-gray-600 mb-4">Panduan lengkap belajar Tailwind CSS dengan mudah dan cepat.</p>
            <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?technology,blog" alt="artikel" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">Kenapa Harus Memulai Blog di 2025?</h3>
            <p class="text-sm text-gray-600 mb-4">Membangun personal branding dan portofolio lewat blog pribadi.</p>
            <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?developer,blog" alt="artikel" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">5 Editor Blog yang Harus Kamu Coba</h3>
            <p class="text-sm text-gray-600 mb-4">Review tools editor blog paling populer untuk menulis dengan nyaman.</p>
            <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'components/footer.php'; ?>

</body>
</html>
