<?php
include '../../connection.php';
session_start();

$base_url = "/blog-app/";

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
	header("Location: {$base_url}index.php");
	exit;
}

// Ambil data artikel + username penulis
$stmt = $connection->prepare("
    SELECT posts.*, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    WHERE posts.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
	echo "Artikel tidak ditemukan.";
	exit;
}

$post = $result->fetch_assoc();

// Ambil kategori terkait dari relasi many-to-many
$cat_stmt = $connection->prepare("
    SELECT c.name 
    FROM categories c 
    JOIN post_categories pc ON c.id = pc.category_id 
    WHERE pc.post_id = ?
");
$cat_stmt->bind_param("i", $id);
$cat_stmt->execute();
$cat_result = $cat_stmt->get_result();

$categories = [];
while ($row = $cat_result->fetch_assoc()) {
	$categories[] = $row['name'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($post['title']) ?> - ClaireBlog</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include '../../components/navbar.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-8">
  <!-- Konten Utama -->
  <div class="md:col-span-2">
    <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($post['title']) ?></h1>

    <!-- Info Penulis -->
    <div class="flex items-center text-sm text-gray-500 mb-3">
      <span>Ditulis oleh <span class="font-medium text-gray-700"><?= htmlspecialchars($post['username']) ?></span></span>
      <span class="mx-2">•</span>
      <span><?= date('d M Y, H:i', strtotime($post['created_at'])) ?></span>
    </div>

    <!-- Kategori -->
		<?php if (!empty($categories)): ?>
      <div class="mb-6">
        <span class="text-sm font-medium text-gray-600">Kategori:</span>
				<?php foreach ($categories as $cat): ?>
          <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
            <?= htmlspecialchars($cat) ?>
          </span>
				<?php endforeach; ?>
      </div>
		<?php endif; ?>

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

  <!-- Sidebar -->
  <div class="md:col-span-1">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Artikel Lainnya</h2>

		<?php
		$related = $connection->query("
    SELECT id, title, slug, image 
    FROM posts 
    WHERE id != {$post['id']} 
    ORDER BY created_at DESC 
    LIMIT 5
  ");
		while ($r = $related->fetch_assoc()):
			$image = !empty($r['image']) ? "../../" . $r['image'] : "https://source.unsplash.com/80x80/?blog";
			?>
      <a href="post.php?id=<?= $r['id'] ?>&slug=<?= urlencode($r['slug']) ?>" class="flex items-center space-x-4 mb-4 hover:bg-gray-100 p-2 rounded transition">
        <img src="<?= htmlspecialchars($image) ?>" alt="Thumbnail" class="w-16 h-16 object-cover rounded-lg border" />
        <div class="flex-1">
          <h3 class="text-sm font-semibold text-gray-700 leading-tight"><?= htmlspecialchars($r['title']) ?></h3>
        </div>
      </a>
		<?php endwhile; ?>
  </div>

</div>

<?php include '../../components/footer.php'; ?>
</body>
</html>
