<?php
session_start();
require_once '../connection.php'; // sesuaikan path-nya
// require_once '../functions/category_functions.php'; // jika ada function untuk ambil data kategori

// Ambil semua kategori dari database
$sql = "SELECT * FROM categories ORDER BY name ASC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Kategori</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">

<?php include '../components/navbar.php'; ?>

<main class="flex-grow">
  <div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Daftar Kategori</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php while ($category = mysqli_fetch_assoc($result)): ?>
          <a href="category_posts.php?id=<?= $category['id']; ?>" class="block bg-white rounded-lg shadow hover:shadow-md transition-all p-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-blue-600"><?= htmlspecialchars($category['name']); ?></h2>
            <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($category['description']); ?></p>
          </a>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">Belum ada kategori.</p>
    <?php endif; ?>
  </div>
</main>

<?php include '../components/footer.php'; ?>
