<?php
require_once "config/Database.php";
require_once "classes/Mahasiswa.php";

$db = new Database();
$conn = $db->getConnection();
$mhs = new Mahasiswa($conn);

$mhs->id = $_GET['id'] ?? null;
if ($mhs->id && $mhs->delete()) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
