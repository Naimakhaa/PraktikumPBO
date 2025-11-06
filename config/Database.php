<?php
class Database {
    // ubah "local" ke "huggingface" kalau diunggah ke Hugging Face
    private $mode = "local";

    private $mysql = [
        "host" => "127.0.0.1",
        "db_name" => "kampus",
        "username" => "root",
        "password" => "",
        "port" => "3306"
    ];

    private $sqlite_file = __DIR__ . "/../kampus.db";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            if ($this->mode === "local") {
                // mode Laragon (MySQL)
                $this->conn = new PDO(
                    "mysql:host={$this->mysql['host']};port={$this->mysql['port']};dbname={$this->mysql['db_name']}",
                    $this->mysql['username'],
                    $this->mysql['password']
                );
                echo "✅ Koneksi MySQL berhasil!<br>";
            } else {
                // mode Hugging Face (SQLite)
                $this->conn = new PDO("sqlite:" . $this->sqlite_file);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec("
                    CREATE TABLE IF NOT EXISTS mahasiswa (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        nama TEXT,
                        nim TEXT UNIQUE,
                        jurusan TEXT
                    )
                ");
                echo "✅ Koneksi SQLite (Hugging Face) berhasil!<br>";
            }
        } catch (PDOException $e) {
            echo "❌ Koneksi gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
