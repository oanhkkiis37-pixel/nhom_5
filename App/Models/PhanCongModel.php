<?php
// App/Models/PhanCongModel.php

class PhanCongModel {
    private $pdo;

    public function __construct() {
        $database = new db();
        $this->pdo = $database->pdo;
    }

    public function getAll($keyword = "") {
        if (!empty($keyword)) {
            $stmt = $this->pdo->prepare("SELECT pc.*, nv.hovaten, da.tenduan FROM phancong pc JOIN nhanvien nv ON pc.manhanvien = nv.manhanvien JOIN duan da ON pc.maduan = da.maduan WHERE nv.hovaten LIKE ? OR da.tenduan LIKE ?");
            $stmt->execute(["%" . $keyword . "%", "%" . $keyword . "%"]);
        } else {
            $stmt = $this->pdo->query("SELECT pc.*, nv.hovaten, da.tenduan FROM phancong pc JOIN nhanvien nv ON pc.manhanvien = nv.manhanvien JOIN duan da ON pc.maduan = da.maduan");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($maphancong) {
        $stmt = $this->pdo->prepare("SELECT * FROM phancong WHERE maphancong = ?");
        $stmt->execute([$maphancong]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNhanVienList() {
        return $this->pdo->query("SELECT manhanvien, hovaten FROM nhanvien")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDuAnList() {
        return $this->pdo->query("SELECT maduan, tenduan FROM duan")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($manhanvien, $maduan, $vaitro, $ngaythamgia) {
        $stmt = $this->pdo->prepare("INSERT INTO phancong (manhanvien, maduan, vaitro, ngaythamgia) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$manhanvien, $maduan, $vaitro, $ngaythamgia]);
    }

    public function update($maphancong, $manhanvien, $maduan, $vaitro, $ngaythamgia) {
        $stmt = $this->pdo->prepare("UPDATE phancong SET manhanvien = ?, maduan = ?, vaitro = ?, ngaythamgia = ? WHERE maphancong = ?");
        return $stmt->execute([$manhanvien, $maduan, $vaitro, $ngaythamgia, $maphancong]);
    }

    public function delete($maphancong) {
        $stmt = $this->pdo->prepare("DELETE FROM phancong WHERE maphancong = ?");
        return $stmt->execute([$maphancong]);
    }
}