<?php
class PhongBanModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM phongban");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $stmt = $this->pdo->prepare("SELECT * FROM phongban WHERE tenphong LIKE ?");
        $stmt->execute(["%" . $keyword . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($maphong) {
        $stmt = $this->pdo->prepare("SELECT * FROM phongban WHERE maphong = ?");
        $stmt->execute([$maphong]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($tenphong, $sonhanvien) {
        $stmt = $this->pdo->prepare("INSERT INTO phongban (tenphong, sonhanvien) VALUES (?, ?)");
        return $stmt->execute([$tenphong, $sonhanvien]);
    }

    public function update($maphong, $tenphong, $sonhanvien) {
        $stmt = $this->pdo->prepare("UPDATE phongban SET tenphong = ?, sonhanvien = ? WHERE maphong = ?");
        return $stmt->execute([$tenphong, $sonhanvien, $maphong]);
    }

    public function delete($maphong) {
        $stmt = $this->pdo->prepare("DELETE FROM phongban WHERE maphong = ?");
        return $stmt->execute([$maphong]);
    }
}
?>