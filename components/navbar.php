<?php 
include __DIR__ . '/../connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = "/";
?>
<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      <!-- Logo -->
      <a href="<?= $base_url ?>index.php" class="text-2xl font-bold text-blue-600">ClaireBlog</a>

      <!-- Menu Desktop -->
      <div class="hidden md:flex space-x-6">
        <a href="<?= $base_url ?>index.php" class="hover:text-blue-600">Home</a>
        <a href="<?= $base_url ?>page/article.php" class="hover:text-blue-600">Artikel</a>
        <a href="<?= $base_url ?>page/category.php" class="hover:text-blue-600">Kategori</a>
        <a href="<?= $base_url ?>page/about.php" class="hover:text-blue-600">Tentang</a>
      </div>

      <!-- Auth / Profile -->
      <div class="hidden md:flex items-center space-x-4 relative">
        <?php if (isset($_SESSION['username'])): ?>
          <!-- Dropdown Trigger -->
          <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 focus:outline-none">
            <div class="text-sm text-gray-700 text-right">
              <div class="font-semibold"><?= htmlspecialchars($_SESSION['username']); ?></div>
              <div class="text-xs"><?= htmlspecialchars($_SESSION['email']); ?></div>
            </div>
            <img 
              src="<?= $base_url . htmlspecialchars($_SESSION['profile_picture']); ?>" 
              onerror="this.onerror=null;this.src='<?= $base_url ?>default.png';"
              alt="Profile" 
              class="w-10 h-10 rounded-full border object-cover"
            />
          </button>

          <!-- Dropdown Menu -->
          <div id="profileDropdown" class="hidden absolute right-0 top-14 bg-white border rounded-md shadow-lg w-48 z-50">
            <a href="<?= $base_url ?>page/edit_profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profile</a>
            <a href="<?= $base_url ?>page/post/create.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Buat Blog</a>
            <a href="<?= $base_url ?>page/my_post.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Blogs</a>
            <a href="<?= $base_url ?>logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
          </div>
        <?php else: ?>
          <a href="<?= $base_url ?>login.php" class="text-gray-700 hover:text-blue-600">Login</a>
          <a href="<?= $base_url ?>register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Daftar</a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden flex items-center">
        <button id="menu-toggle" class="text-gray-700 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
    <a href="<?= $base_url ?>index.php" class="block py-2 hover:text-blue-600">Home</a>
    <a href="<?= $base_url ?>page/article.php" class="block py-2 hover:text-blue-600">Artikel</a>
    <a href="<?= $base_url ?>page/category.php" class="block py-2 hover:text-blue-600">Kategori</a>
    <a href="<?= $base_url ?>page/about.php" class="block py-2 hover:text-blue-600">Tentang</a>
    <hr class="my-2">
    <?php if (isset($_SESSION['username'])): ?>
      <div class="py-2 text-sm">
        <div class="font-semibold"><?= htmlspecialchars($_SESSION['username']); ?></div>
        <div class="text-xs mb-2"><?= htmlspecialchars($_SESSION['email']); ?></div>
        <a href="<?= $base_url ?>edit_profile.php" class="block py-1 hover:text-blue-600">Edit Profil</a>
        <a href="<?= $base_url ?>page/my_posts.php" class="block py-1 hover:text-blue-600">My Blogs</a>
        <a href="<?= $base_url ?>logout.php" class="block py-1 text-red-500 hover:text-red-600">Logout</a>
      </div>
    <?php else: ?>
      <a href="<?= $base_url ?>login.php" class="block py-2 hover:text-blue-600">Login</a>
      <a href="<?= $base_url ?>register.php" class="block py-2 hover:text-blue-600">Daftar</a>
    <?php endif; ?>
  </div>
</nav>

<!-- Scripts -->
<script>
  // Mobile menu toggle
  const toggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('mobile-menu');
  toggle.addEventListener('click', () => {
    menu.classList.toggle('hidden');
  });

  // Profile dropdown toggle
  function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
  }

  // Klik di luar dropdown untuk menutup
  window.addEventListener("click", function (e) {
    const dropdown = document.getElementById("profileDropdown");
    const button = e.target.closest("button");
    if (!button && !e.target.closest("#profileDropdown")) {
      dropdown.classList.add("hidden");
    }
  });
</script>
