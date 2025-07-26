<?php
session_start();
require_once '../connection.php';

$sql = "SELECT * FROM categories ORDER BY name ASC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Kategori</title>

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
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Kategori Artikel</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="flex flex-wrap gap-3 justify-center">
        <?php while ($category = mysqli_fetch_assoc($result)): ?>
          <a href="category_posts.php?id=<?= $category['id']; ?>"
             class="inline-block bg-blue-100 text-blue-700 px-4 py-2 text-sm rounded-full border border-blue-300 hover:bg-blue-200 transition">
            <?= htmlspecialchars($category['name']); ?>
          </a>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">Belum ada kategori.</p>
    <?php endif; ?>
  </div>
</main>

<?php include '../components/footer.php'; ?>
</body>
</html>
