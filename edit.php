<?php
require_once "config/Database.php";
require_once "classes/Mahasiswa.php";

$db = new Database();
$conn = $db->getConnection();
$mhs = new Mahasiswa($conn);

$id = $_GET['id'] ?? null;
if (!$id) die("ID tidak ditemukan.");

$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id=:id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    $mhs->id = $id;
    $mhs->nama = $_POST['nama'];
    $mhs->nim = $_POST['nim'];
    $mhs->jurusan = $_POST['jurusan'];

    if ($mhs->update()) {
        header("Location: index.php");
        exit;
    }
}
?>
<form method="POST">
    Nama: <input type="text" name="nama" value="<?= $data['nama'] ?>"><br>
    NIM: <input type="text" name="nim" value="<?= $data['nim'] ?>"><br>
    Jurusan: <input type="text" name="jurusan" value="<?= $data['jurusan'] ?>"><br>
    <button type="submit">Update</button>
</form>
