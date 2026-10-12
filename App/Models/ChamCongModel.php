<?php
// App/Models/ChamCongModel.php

class ChamCongModel {
    private $pdo;

    public function __construct() {
        $database = new db();
        $this->pdo = $database->pdo;
    }

    public function getAll($keyword = "") {
        if (!empty($keyword)) {
            $stmt = $this->pdo->prepare("SELECT cc.*, nv.hovaten, nv.luongcoban FROM chamcong cc JOIN nhanvien nv ON cc.manhanvien = nv.manhanvien WHERE nv.hovaten LIKE ? OR cc.thang LIKE ? OR cc.nam LIKE ?");
            $stmt->execute(["%" . $keyword . "%", "%" . $keyword . "%", "%" . $keyword . "%"]);
        } else {
            $stmt = $this->pdo->query("SELECT cc.*, nv.hovaten, nv.luongcoban FROM chamcong cc JOIN nhanvien nv ON cc.manhanvien = nv.manhanvien");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($machamcong) {
        $stmt = $this->pdo->prepare("SELECT * FROM chamcong WHERE machamcong = ?");
        $stmt->execute([$machamcong]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNhanVienList() {
        return $this->pdo->query("SELECT manhanvien, hovaten FROM nhanvien")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong) {
        $stmt = $this->pdo->prepare("INSERT INTO chamcong (manhanvien, thang, nam, sogiolam, phucap, thuong) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong]);
    }

    public function update($machamcong, $manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong) {
        $stmt = $this->pdo->prepare("UPDATE chamcong SET manhanvien = ?, thang = ?, nam = ?, sogiolam = ?, phucap = ?, thuong = ? WHERE machamcong = ?");
        return $stmt->execute([$manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong, $machamcong]);
    }

    public function delete($machamcong) {
        $stmt = $this->pdo->prepare("DELETE FROM chamcong WHERE machamcong = ?");
        return $stmt->execute([$machamcong]);
    }
}