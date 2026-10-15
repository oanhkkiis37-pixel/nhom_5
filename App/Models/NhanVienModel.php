<?php
// App/Models/NhanVienModel.php

class NhanVienModel {
    private $pdo;

    public function __construct() {
        $database = new db();
        $this->pdo = $database->pdo;
    }

    public function getAll($keyword = "") {
        if (!empty($keyword)) {
            $stmt = $this->pdo->prepare("SELECT nv.*, pb.tenphong FROM nhanvien nv LEFT JOIN phongban pb ON nv.maphong = pb.maphong WHERE nv.hovaten LIKE ?");
            $stmt->execute(["%" . $keyword . "%"]);
        } else {
            $stmt = $this->pdo->query("SELECT nv.*, pb.tenphong FROM nhanvien nv LEFT JOIN phongban pb ON nv.maphong = pb.maphong");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($manhanvien) {
        $stmt = $this->pdo->prepare("SELECT * FROM nhanvien WHERE manhanvien = ?");
        $stmt->execute([$manhanvien]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPhongBanList() {
        return $this->pdo->query("SELECT * FROM phongban")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO nhanvien (hovaten, ngaysinh, sdt, chucvu, luongcoban, maphong, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['hovaten'], 
            $data['ngaysinh'], 
            $data['sdt'], 
            $data['chucvu'], 
            $data['luongcoban'], 
            $data['maphong'], 
            $data['username'], 
            $data['password']
        ]);
    }

    public function update($data, $hasPassword) {
        if ($hasPassword) {
            $stmt = $this->pdo->prepare("UPDATE nhanvien SET hovaten = ?, ngaysinh = ?, sdt = ?, chucvu = ?, luongcoban = ?, maphong = ?, username = ?, password = ? WHERE manhanvien = ?");
            return $stmt->execute([
                $data['hovaten'], 
                $data['ngaysinh'], 
                $data['sdt'], 
                $data['chucvu'], 
                $data['luongcoban'], 
                $data['maphong'], 
                $data['username'], 
                $data['password'],
                $data['manhanvien']
            ]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE nhanvien SET hovaten = ?, ngaysinh = ?, sdt = ?, chucvu = ?, luongcoban = ?, maphong = ?, username = ? WHERE manhanvien = ?");
            return $stmt->execute([
                $data['hovaten'], 
                $data['ngaysinh'], 
                $data['sdt'], 
                $data['chucvu'], 
                $data['luongcoban'], 
                $data['maphong'], 
                $data['username'],
                $data['manhanvien']
            ]);
        }
    }

    public function delete($manhanvien) {
        $stmt = $this->pdo->prepare("DELETE FROM nhanvien WHERE manhanvien = ?");
        return $stmt->execute([$manhanvien]);
    }
}
