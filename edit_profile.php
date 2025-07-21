<?php
include 'connection.php';
session_start();

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
    $new_email = $_POST['email'];
    $profile_picture = $user['profile_picture']; // default lama

    // Proses upload gambar
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $filename = basename($_FILES["profile_picture"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $filename;
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath);
        $profile_picture = $targetFilePath;
    }

    $update = $connection->prepare("UPDATE users SET email = ?, profile_picture = ? WHERE username = ?");
    $update->bind_param("sss", $new_email, $profile_picture, $username);

    if ($update->execute()) {
        $_SESSION['email'] = $new_email;
        $_SESSION['profile_picture'] = $profile_picture;
        echo "<script>alert('Profil berhasil diperbarui'); window.location='edit_profile.php';</script>";
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
  <title>ClaireBlog - Edit Profil</title>
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

  <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md mt-10 mb-10 text-center">
            <h2 class="text-2xl font-bold mb-6">Edit Profil</h2>

            <!-- Gambar Profil -->
            <div class="mb-4 flex flex-col items-center">
                <img src="<?php echo $user['profile_picture'] ?? 'default.png'; ?>"
                     alt="Foto Profil" class="w-28 h-28 rounded-full object-cover border shadow mb-2">
            </div>

            <!-- Form -->
            <form method="POST" enctype="multipart/form-data" class="text-left">
                <!-- Email -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                           required>
                </div>

                <!-- Input File Gambar -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Ganti Gambar Profil</label>
                    <input type="file" name="profile_picture" accept="image/*" class="w-full">
                </div>

                <!-- Tombol Simpan -->
                <div class="text-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

  <!-- Footer -->
  <?php include 'components/footer.php'; ?>

</body>
</html>
