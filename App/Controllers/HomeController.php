<?php
// App/Controllers/HomeController.php

class HomeController {
    public function index() {
        // Nạp giao diện trang chủ công khai (chưa cần đăng nhập)
        require_once __DIR__ . '/../Views/dashboard_public.php'; 
    }
}