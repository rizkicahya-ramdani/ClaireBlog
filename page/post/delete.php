<?php
include '../../connection.php';
session_start();

$base_url = "/blog-app/";

if (!isset($_SESSION['user_id'])) {
    header("Location: {$base_url}login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: {$base_url}page/my_post.php");
    exit;
}

$stmt = $connection->prepare("SELECT image FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Postingan tidak ditemukan atau Anda tidak memiliki akses.";
    exit;
}

$post = $result->fetch_assoc();
$imagePath = $post['image'];

if (!empty($imagePath)) {
    $fullImagePath = dirname(__DIR__, 2) . '/' . $imagePath;
    if (file_exists($fullImagePath)) {
        unlink($fullImagePath);
    }
}

$stmt = $connection->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

header("Location: {$base_url}page/my_post.php");
exit;
