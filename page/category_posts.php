<?php
session_start();
require_once '../connection.php';

$category_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil nama kategori
$category_query = $connection->prepare("SELECT name FROM categories WHERE id = ?");
$category_query->bind_param("i", $category_id);
$category_query->execute();
$category_result = $category_query->get_result();

if ($category_result->num_rows === 0) {
    echo "<h1>Kategori tidak ditemukan.</h1>";
    exit;
}
$category = $category_result->fetch_assoc();

// Ambil artikel berdasarkan relasi post_category
$post_query = $connection->prepare("
    SELECT p.* 
    FROM posts p
    JOIN post_categories pc ON p.id = pc.post_id
    WHERE pc.category_id = ? AND p.status = 'published'
    ORDER BY p.created_at DESC
");
$post_query->bind_param("i", $category_id);
$post_query->execute();
$posts = $post_query->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - <?= htmlspecialchars($category['name']) ?></title>

   <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">
  
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <?php include '../components/navbar.php'; ?>

  <main class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">
      Kategori: <?= htmlspecialchars($category['name']) ?>
    </h1>

    <?php if ($posts->num_rows > 0): ?>
      <div class="space-y-8">
        <?php while ($row = $posts->fetch_assoc()): ?>
          <div class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
            <?php if (!empty($row['image'])): ?>
              <img src="/blog-app/<?= htmlspecialchars($row['image']) ?>" alt="gambar artikel" class="w-full h-64 object-cover">
            <?php endif; ?>
            <div class="p-6">
              <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h2>
              <p class="text-sm text-gray-600 mb-4"><?= substr(strip_tags($row['content']), 0, 150) ?>...</p>
              <a href="../page/read.php?slug=<?= htmlspecialchars($row['slug']) ?>" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">Belum ada artikel di kategori ini.</p>
    <?php endif; ?>
  </main>

  <?php include '../components/footer.php'; ?>
</body>
</html>
