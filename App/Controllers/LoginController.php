<?php
// App/Controllers/LoginController.php

class LoginController {
    public function index() {
        // Nếu đã đăng nhập rồi thì đá thẳng về dashboard
        if (isset($_SESSION["username"])) {
            header("Location: index.php?controller=Dashboard&action=index");
            exit();
        }

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = $_POST["password"] ?? "";

            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!";
            } else {
                $loginModel = new LoginModel();
                $user = $loginModel->checkLogin($username, $password);

                if ($user) {
                    $_SESSION["manhanvien"] = $user['manhanvien'];
                    $_SESSION["username"]   = $username;
                    $_SESSION["hovaten"]    = $user['hovaten'];

                    // Đăng nhập thành công chuyển hướng về index (chạy vào Dashboard)
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
                }
            }
        }

        // Gọi View hiển thị trang đăng nhập
        require_once __DIR__ . '/../Views/Log/login.php';
    }

    public function logout() {
        // Xử lý đăng xuất
        if (isset($_SESSION["username"])) {
            unset($_SESSION["username"]);
            unset($_SESSION["manhanvien"]);
            unset($_SESSION["hovaten"]);
            unset($_SESSION["role"]);
        }
        session_destroy();
        header("Location: index.php");
        exit();
    }
}