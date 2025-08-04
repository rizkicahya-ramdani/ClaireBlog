<?php
include '../../connection.php';
session_start();

$base_url = "/blog-app/";

$id = $_GET['id'] ?? null;
if (!$id) {
	header("Location: {$base_url}index.php");
	exit;
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
	$user_name = $_POST['user_name'];
	$user_email = $_POST['user_email'];
	$content = $_POST['content'];

	$comment_stmt = $connection->prepare("INSERT INTO comments (post_id, user_name, user_email, content, status) VALUES (?, ?, ?, ?, 'approved')");
	$comment_stmt->bind_param("isss", $id, $user_name, $user_email, $content);
	$comment_stmt->execute();
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

    <div class="mt-10">
      <h2 class="text-2xl font-semibold mb-4">Buat Komentar</h2>
      <form action="" method="POST" class="space-y-4">
        <input type="text" name="user_name" placeholder="Nama Anda" required class="w-full p-2 border rounded" />
        <input type="email" name="user_email" placeholder="Email Anda" required class="w-full p-2 border rounded" />
        <textarea name="content" rows="4" placeholder="Tulis komentar..." required class="w-full p-2 border rounded"></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
      </form>
    </div>

    <!-- Daftar Komentar -->
    <div class="mt-10">
      <h2 class="text-2xl font-semibold mb-4">Komentar</h2>
			<?php
			$comment_q = $connection->prepare("SELECT * FROM comments WHERE post_id = ? AND status = 'approved' ORDER BY created_at DESC");
			$comment_q->bind_param("i", $id);
			$comment_q->execute();
			$comments = $comment_q->get_result();

			if ($comments->num_rows === 0): ?>
        <p class="text-gray-500">Belum ada komentar.</p>
			<?php else:
				while ($c = $comments->fetch_assoc()): ?>
          <div class="border rounded p-4 mb-4 bg-white">
            <div class="text-sm font-semibold"><?= htmlspecialchars($c['user_name']) ?></div>
            <div class="text-xs text-gray-500 mb-2"><?= date('d M Y, H:i', strtotime($c['created_at'])) ?></div>
            <p><?= nl2br(htmlspecialchars($c['content'])) ?></p>
          </div>
				<?php endwhile; endif; ?>
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
