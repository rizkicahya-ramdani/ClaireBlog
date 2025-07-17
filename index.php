<?php

include "connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="#" class="text-xl font-bold text-blue-600">MyBlog</a>
            </div>

            <!-- Menu Utama -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">Artikel</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">Kategori</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">Tentang</a>
            </div>

            <!-- Tombol Login/Register -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">Login</a>
                <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Register</a>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="md:hidden flex items-center">
                <button id="menu-toggle" class="text-gray-700 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                </button>
            </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Home</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Artikel</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Kategori</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Tentang</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Login</a>
            <a href="#" class="block py-2 bg-blue-600 text-white rounded text-center hover:bg-blue-700">Register</a>
        </div>

        <!-- Toggle Script -->
        <script>
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            });
        </script>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-8 bg-white shadow-md rounded-lg mt-8 mb-8">
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Username</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-left">Created At</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    <?php
                    
                    $showdata = mysqli_query($connection, "SELECT * FROM users");
                    while ($data = mysqli_fetch_array($showdata)) {
                    
                    ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6"><?= $data['username'] ?></td>
                        <td class="py-3 px-6"><?= $data['email'] ?></td>
                        <td class="py-3 px-6"><?= $data['role'] ?></td>
                        <td class="py-3 px-6"><?= $data['created_at'] ?></td>
                        <td class="py-3 px-6 text-center">
                            <button class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                            <button class="text-red-500 hover:text-red-700">Hapus</button>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- Ulangi baris ini sesuai jumlah data -->
                </tbody>
            </table>
        </div>

    </section>
</body>
</html>