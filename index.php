<?php
include 'connection.php';
session_start();

$hero_query = "SELECT posts.*, users.username 
               FROM posts 
               JOIN users ON posts.user_id = users.id 
               ORDER BY created_at DESC LIMIT 1";
$hero_result = mysqli_query($connection, $hero_query);
$latest_post = mysqli_fetch_assoc($hero_result);

$list_query = "SELECT posts.*, users.username 
               FROM posts 
               JOIN users ON posts.user_id = users.id 
               ORDER BY created_at DESC LIMIT 6 OFFSET 1";
$list_result = mysqli_query($connection, $list_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Beranda</title>

  <!-- Fonts & Tailwind -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include 'components/navbar.php'; ?>

<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">

    <div class="md:col-span-2">

			<?php if ($latest_post): ?>
        <div class="flex flex-col md:flex-row bg-white rounded-xl shadow overflow-hidden">
          <div class="md:w-1/2 h-64 md:h-auto overflow-hidden">
            <img src="<?= htmlspecialchars($latest_post['image']) ?: 'https://source.unsplash.com/800x600/?blog' ?>"
                 alt="<?= htmlspecialchars($latest_post['title']) ?>"
                 class="w-full h-full object-cover">
          </div>

          <div class="md:w-1/2 p-6 flex flex-col justify-between">
            <div>
              <h3 class="text-2xl font-bold mb-2 text-gray-800"><?= htmlspecialchars($latest_post['title']) ?></h3>
              <p class="text-sm text-gray-600 mb-4">
                Oleh <span class="font-semibold"><?= htmlspecialchars($latest_post['username']) ?></span> • <?= date('d M Y', strtotime($latest_post['created_at'])) ?>
              </p>
              <p class="text-gray-700 mb-6"><?= substr(strip_tags($latest_post['content']), 0, 160) ?>...</p>
            </div>
            <a href="page/post/post.php?id=<?= $latest_post['id'] ?>" class="self-start mt-auto inline-block text-white bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg font-medium transition">
              Baca Selengkapnya
            </a>
          </div>
        </div>
			<?php else: ?>
        <p class="text-gray-500">Belum ada artikel terbaru.</p>
			<?php endif; ?>
    </div>

    <aside class="mt-6">
      <h2 class="text-xl font-semibold mb-4">Kategori</h2>
      <div class="flex flex-wrap gap-2">
				<?php
				$categories = mysqli_query($connection, "SELECT * FROM categories ORDER BY name ASC");
				while ($cat = mysqli_fetch_assoc($categories)):
					?>
          <a href="page/category_posts.php?id=<?= $cat['id'] ?>"
             class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 transition">
						<?= htmlspecialchars($cat['name']) ?>
          </a>
				<?php endwhile; ?>
      </div>
    </aside>

  </div>
</section>



<section id="artikel" class="py-16 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-2xl font-bold mb-8 text-center">Artikel Terbaru</h2>

    <div class="grid md:grid-cols-3 gap-8">
			<?php if ($list_result->num_rows > 0): ?>
				<?php while($row = $list_result->fetch_assoc()): ?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
						<?php if (!empty($row['image'])): ?>
              <img src="<?= htmlspecialchars($row['image']) ?>" alt="artikel" class="w-full h-48 object-cover">
						<?php else: ?>
              <img src="https://source.unsplash.com/600x400/?blog" alt="artikel" class="w-full h-48 object-cover">
						<?php endif; ?>

            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h3>
              <p class="text-sm text-gray-600 mb-1">
                Oleh <span class="font-medium"><?= htmlspecialchars($row['username']) ?></span> • <?= date('d M Y', strtotime($row['created_at'])) ?>
              </p>
              <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars(substr(strip_tags($row['content']), 0, 100)) ?>...</p>
              <a href="page/post/post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline text-sm">Baca selengkapnya →</a>
            </div>
          </div>
				<?php endwhile; ?>
			<?php else: ?>
        <p class="text-center text-gray-500 col-span-3">Belum ada artikel tambahan.</p>
			<?php endif; ?>
    </div>
  </div>
</section>

<?php include 'components/footer.php'; ?>
</body>
</html>

