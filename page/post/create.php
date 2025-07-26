<?php
include '../../connection.php';
session_start();

$success = $error = "";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: ../../login.php');
    exit;
}

function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);  
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

// Ambil semua kategori
$categories = [];
$categoryQuery = $connection->query("SELECT id, name FROM categories");
while ($row = $categoryQuery->fetch_assoc()) {
    $categories[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title'];
    $content     = $_POST['content'];
    $status      = $_POST['status'];
    $category_id = $_POST['category_id'];
    $slug        = generateSlug($title);

    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = dirname(__DIR__, 2) . '/uploads/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'uploads/' . $imageName;
        } else {
            $error = "Gagal mengunggah gambar.";
        }
    }

    if (!$error) {
        $stmt = $connection->prepare("
            INSERT INTO posts (user_id, title, slug, content, image, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("isssss", $user_id, $title, $slug, $content, $imagePath, $status);

        if ($stmt->execute()) {
            $post_id = $stmt->insert_id;

            // Simpan relasi kategori
            $stmt_cat = $connection->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)");
            $stmt_cat->bind_param("ii", $post_id, $category_id);
            $stmt_cat->execute();

            $success = "Artikel berhasil disimpan!";
        } else {
            $error = "Gagal menyimpan artikel: " . $stmt->error;
        }
    }
}
?>




<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ClaireBlog - Tulis Artikel</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include '../../components/navbar.php'; ?>

  <div class="max-w-3xl mx-auto py-16 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">

      <h1 class="text-2xl font-bold mb-6 text-gray-800">Tulis Artikel Baru</h1>

      <?php if (!empty($success)): ?>
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 border border-green-300"><?= $success ?></div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4 border border-red-300"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
          <label class="block mb-1 font-medium text-gray-700">Judul</label>
          <input type="text" name="title" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700">Isi Artikel</label>
          <textarea name="content" rows="6" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700">Upload Gambar</label>
          <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 px-4 py-2 rounded-lg bg-white">
        </div>

        <div>
          <label class="block mb-1 font-medium">Kategori</label>
          <select name="category_id" class="w-full border px-4 py-2 rounded">
            <?php
              $categoryResult = $connection->query("SELECT * FROM categories");
              while ($cat = $categoryResult->fetch_assoc()):
            ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium text-gray-700">Status</label>
          <select name="status" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
          </select>
        </div>

        <div class="pt-4">
          <button type="submit" name="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Simpan Artikel
          </button>
        </div>
      </form>

    </div>
  </div>



  <?php include '../../components/footer.php'; ?>
</body>
</html>
