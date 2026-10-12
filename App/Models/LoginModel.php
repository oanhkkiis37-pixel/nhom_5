<?php
// App/Models/LoginModel.php

class LoginModel {
    public function checkLogin($username, $password) {
        $database = new db();
        $pdo = $database->pdo;

        $stmt = $pdo->prepare("SELECT manhanvien, hovaten, password FROM nhanvien WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $password === $result['password']) {
            return $result; // Trả về thông tin nhân viên nếu đúng
        }
        return false; // Sai tài khoản hoặc mật khẩu
    }
}