<?php
include '../../connection.php';
session_start();

$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    echo "Post tidak ditemukan.";
    exit;
}

// Ambil data post berdasarkan ID
$stmt = $connection->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post tidak ditemukan.";
    exit;
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($post['title']) ?></title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  
  <?php include '../../components/navbar.php'; ?>
  <div class="max-w-4xl mx-auto px-4 py-10">
    
    <!-- Judul -->
    <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($post['title']) ?></h1>

    <!-- Info Penulis -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
      <span>Ditulis oleh <span class="font-medium text-gray-700"><?= htmlspecialchars($post['username']) ?></span></span>
      <span class="mx-2">•</span>
      <span><?= date('d M Y, H:i', strtotime($post['created_at'])) ?></span>
    </div>

    <!-- Gambar -->
    <?php if (!empty($post['image'])): ?>
      <img src="../../<?= htmlspecialchars($post['image']) ?>" alt="Gambar artikel" class="w-full h-auto rounded-lg shadow mb-8">
    <?php endif; ?>

    <!-- Konten -->
    <div class="prose max-w-none text-lg">
      <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-10">
      <a href="../../index.php" class="inline-block text-blue-600 hover:underline text-sm">← Kembali ke Beranda</a>
    </div>
  </div>
  <?php include '../../components/footer.php'; ?>
</body>
</html>
