<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ClaireBlog - My Posts</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <?php include '../components/navbar.php'; ?>

  <div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6">My Blog Posts</h1>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="bg-white rounded-lg shadow-md mb-6 p-6">
        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h2>
        <p class="text-sm text-gray-500 mb-2"><?= date('d M Y', strtotime($row['created_at'])) ?></p>
        
        <?php if (!empty($row['image'])): ?>
          <img src="../<?= htmlspecialchars($row['image']) ?>" alt="cover" class="w-full h-64 object-cover rounded mb-4">
        <?php endif; ?>

        <p class="text-gray-700 mb-4"><?= substr(strip_tags($row['content']), 0, 200) ?>...</p>
        
        <div class="flex space-x-4">
          <a href="post/post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">View</a>
          <a href="post/edit.php?id=<?= $row['id'] ?>" class="text-yellow-600 hover:underline">Edit</a>
          <a href="post/delete.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
        </div>
      </div>
    <?php endwhile; ?>

    <?php if ($result->num_rows === 0): ?>
      <p class="text-gray-600">Anda belum post apapun.</p>
    <?php endif; ?>
  </div>

  <?php include '../components/footer.php'; ?>
</body>
</html>
