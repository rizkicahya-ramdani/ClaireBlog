<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

// Ambil data pengguna
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$new_name = $_POST['name'];
	$new_email = $_POST['email'];

	$update = $connection->prepare("UPDATE users SET name = ?, email = ? WHERE username = ?");
	$update->bind_param("sss", $new_name, $new_email, $username);

	if ($update->execute()) {
			$_SESSION['email'] = $new_email;
			echo "<script>alert('Profil berhasil diperbarui');window.location='edit_profile.php';</script>";
	} else {
			echo "<script>alert('Gagal memperbarui profil');</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
	<!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

  <!-- Navbar -->
  <?php include 'components/navbar.php'; ?>

  <!-- Form (Konten utama) -->
  <main class="flex-grow">
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Edit Profil</h2>
      <form method="POST" class="space-y-5">
        
        <div>
          <label class="block mb-1 font-semibold">Username (tidak dapat diubah)</label>
          <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled 
                class="w-full px-4 py-2 border rounded bg-gray-100 text-gray-500 cursor-not-allowed">
        </div>

        <div>
          <label class="block mb-1 font-semibold">Email</label>
          <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="text-center">
          <button type="submit"
                  class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'components/footer.php'; ?>

</body>
</html>
