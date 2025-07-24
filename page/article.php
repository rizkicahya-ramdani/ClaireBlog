<?php 

include '../connection.php';

$result = $connection->query("SELECT posts.*, users.username FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        ORDER BY posts.created_at DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ClaireBlog - Artikel</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include '../components/navbar.php'; ?>

  <section id="artikel" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-2xl font-bold mb-8 text-center">Artikel Terbaru</h2>

      <div class="grid md:grid-cols-3 gap-8">
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <?php if (!empty($row['image'])): ?>
                <img src="<?= '../' . htmlspecialchars($row['image']) ?>" alt="artikel" class="w-full h-48 object-cover">
              <?php else: ?>
                <img src="https://source.unsplash.com/600x400/?blog" alt="artikel" class="w-full h-48 object-cover">
              <?php endif; ?>
              
              <div class="p-4">
                <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h3>
                <p class="text-sm text-gray-600 mb-1">Oleh <span class="font-medium"><?= htmlspecialchars($row['username']) ?></span> • <?= date('d M Y', strtotime($row['created_at'])) ?></p>
                <p class="text-sm text-gray-600 mb-4"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
                <a href="post/post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center text-gray-500 col-span-3">Belum ada artikel.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php include '../components/footer.php'; ?>

</body>
</html>
