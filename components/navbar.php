<?php 

include 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 flex justify-between h-16 items-center">
    
    <a href="#" class="text-2xl font-bold text-blue-600">ClaireBlog</a>

    <div class="hidden md:flex space-x-6">
      <a href="#" class="hover:text-blue-600">Home</a>
      <a href="#" class="hover:text-blue-600">Artikel</a>
      <a href="#" class="hover:text-blue-600">Kategori</a>
      <a href="#" class="hover:text-blue-600">Tentang</a>
    </div>

    <div class="hidden md:flex items-center space-x-4">
      <?php if (isset($_SESSION['username'])): ?>
        <div class="text-sm text-gray-700 text-right">
          <div class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
          <div class="text-xs"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
        </div>
        <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Logout</a>
      <?php else: ?>
        <a href="/login.php" class="text-gray-700 hover:text-blue-600">Login</a>
        <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
