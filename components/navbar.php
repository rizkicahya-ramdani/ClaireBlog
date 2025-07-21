<?php 

include __DIR__ . '/../connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = "/blog-app/";

?>
<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 flex justify-between h-16 items-center">
    
    <a href="#" class="text-2xl font-bold text-blue-600">ClaireBlog</a>

    <div class="hidden md:flex space-x-6">
      <a href="<?= $base_url ?>index.php" class="hover:text-blue-600">Home</a>
      <a href="<?= $base_url ?>page/article.php" class="hover:text-blue-600">Artikel</a>
      <a href="<?= $base_url ?>page/category.php" class="hover:text-blue-600">Kategori</a>
      <a href="<?= $base_url ?>page/about.php" class="hover:text-blue-600">Tentang</a>
    </div>

    <div class="hidden md:flex items-center space-x-4">
      <?php if (isset($_SESSION['username'])): ?>
        <div class="flex items-center space-x-3">
          <!-- Username and Email -->
          <a href="edit_profile.php">
            <div class="text-sm text-gray-700 text-right">
              <div class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
              <div class="text-xs"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
            </div>
          </a>
        </div>
        <!-- Profile Picture -->
        <img 
          src="<?= $base_url . htmlspecialchars($_SESSION['profile_picture']); ?>" 
          onerror="this.onerror=null;this.src='<?= $base_url ?>default.png';"
          alt="Profile" 
          class="w-10 h-10 rounded-full border object-cover"
        />
        <a href="<?= $base_url ?>logout.php" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Logout</a>
      <?php else: ?>
        <a href="/login.php" class="text-gray-700 hover:text-blue-600">Login</a>
        <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

