<?php
class Database {
    private $db_file = __DIR__ . '/../kampus.db';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("sqlite:" . $this->db_file);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS mahasiswa (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nama TEXT,
                    nim TEXT UNIQUE,
                    jurusan TEXT
                )
            ");
        } catch (PDOException $e) {
            echo "❌ Koneksi gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
