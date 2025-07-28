<?php
include '../../connection.php';
session_start();

$base_url = "/blog-app/";

if (!isset($_SESSION['user_id'])) {
	header("Location: {$base_url}login.php");
	exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;
$success = $error = "";

if (!$id) {
	header("Location: {$base_url}index.php");
	exit;
}

// Ambil data artikel
$stmt = $connection->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
	echo "Artikel tidak ditemukan atau Anda tidak punya akses.";
	exit;
}
$post = $result->fetch_assoc();

// Ambil semua kategori
$category_result = mysqli_query($connection, "SELECT * FROM categories ORDER BY name ASC");

// Ambil kategori yang dipilih artikel ini
$selected_categories = [];
$category_query = $connection->prepare("SELECT category_id FROM post_categories WHERE post_id = ?");
$category_query->bind_param("i", $id);
$category_query->execute();
$category_result_set = $category_query->get_result();
while ($cat = $category_result_set->fetch_assoc()) {
	$selected_categories[] = $cat['category_id'];
}

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['title'] ?? '';
	$content = $_POST['content'] ?? '';
	$status = $_POST['status'] ?? 'draft';
	$category_ids = $_POST['category_ids'] ?? [];
	$imagePath = $post['image'];

	// Upload image baru jika ada
	if (!empty($_FILES['image']['name'])) {
		$uploadDir = dirname(__DIR__, 2) . '/uploads/';
		$imageName = time() . '_' . basename($_FILES['image']['name']);
		$uploadFile = $uploadDir . $imageName;

		if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
			$imagePath = 'uploads/' . $imageName;
		} else {
			$error = "Gagal mengunggah gambar.";
		}
	}

	if (!$error) {
		// Update post
		$stmt = $connection->prepare("UPDATE posts SET title = ?, content = ?, image = ?, status = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
		$stmt->bind_param("ssssii", $title, $content, $imagePath, $status, $id, $user_id);
		if ($stmt->execute()) {
			// Update kategori: hapus semua lalu insert ulang
			$connection->query("DELETE FROM post_categories WHERE post_id = $id");

			$insert_stmt = $connection->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)");
			foreach ($category_ids as $cat_id) {
				$insert_stmt->bind_param("ii", $id, $cat_id);
				$insert_stmt->execute();
			}

			$success = "Artikel berhasil diperbarui!";
			// Update tampilan data setelah perubahan
			$post['title'] = $title;
			$post['content'] = $content;
			$post['image'] = $imagePath;
			$post['status'] = $status;
			$selected_categories = $category_ids;
		} else {
			$error = "Gagal memperbarui artikel.";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ClaireBlog - Edit Post</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../style.css">
  
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <?php include '../../components/navbar.php'; ?>

  <div class="max-w-3xl mx-auto py-10 px-6 bg-white shadow-md rounded-md mt-10">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Edit Artikel</h2>

    <?php if ($success): ?>
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">Judul</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" class="w-full border px-4 py-2 rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">Konten</label>
        <textarea name="content" rows="6" class="w-full border px-4 py-2 rounded" required><?= htmlspecialchars($post['content']) ?></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">Gambar</label>
        <?php if (!empty($post['image'])): ?>
          <img src="<?= $base_url . $post['image'] ?>" alt="Gambar Artikel" class="w-40 mb-2 rounded">
        <?php endif; ?>
        <input type="file" name="image" class="w-full border px-2 py-1 rounded">
      </div>

      <div class="mb-4">
        <label class="block font-medium mb-1">Kategori</label>
        <div class="grid grid-cols-2 gap-2">
					<?php while ($cat = mysqli_fetch_assoc($category_result)): ?>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="category_ids[]" value="<?= $cat['id'] ?>"
								<?= in_array($cat['id'], $selected_categories) ? 'checked' : '' ?>>
              <span><?= htmlspecialchars($cat['name']) ?></span>
            </label>
					<?php endwhile; ?>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">Status</label>
        <select name="status" class="w-full border px-4 py-2 rounded">
          <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
          <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          <option value="archived" <?= $post['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
        </select>
      </div>

      <div class="flex justify-end items-center gap-4 mt-8">
        <a href="<?= $base_url ?>page/my_post.php" class="text-blue-600 hover:underline">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Update</button>
      </div>
    </form>
  </div>

  <?php include '../../components/footer.php'; ?>
</body>
</html>
