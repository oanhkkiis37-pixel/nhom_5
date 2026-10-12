<?php
// App/Controllers/DashboardController.php

class DashboardController {
    public function index() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION["username"])) {
            // NẾU CHƯA ĐĂNG NHẬP: Hiển thị giao diện trang chủ công khai
            // Bạn hãy tạo file dashboard_public.php trong thư mục App/Views/ để chứa HTML trang chủ công khai nhé
            require_once __DIR__ . '/../Views/layouts/dashboard_public.php';
            return;
        }

        // NẾU ĐÃ ĐĂNG NHẬP: Xử lý logic hiển thị trang quản trị/dashboard cá nhân
        $database = new db();
        $pdo = $database->pdo;
        $username = $_SESSION["username"];

        // Lấy thông tin nhân viên
        $stmt = $pdo->prepare("SELECT manhanvien, hovaten, chucvu, luongcoban FROM nhanvien WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            session_destroy();
            header("Location: index.php?controller=Login&action=index");
            exit();
        }

        $manhanvien = $user['manhanvien'];
        $hovaten    = $user['hovaten'];
        $chucvu     = $user['chucvu'];
        $luongcoban = floatval($user['luongcoban'] ?? 0);

        // Phân quyền
        $role = (in_array(strtolower($chucvu), ['giám đốc', 'trưởng phòng hr', 'admin'])) ? "admin" : "user";
        $_SESSION["role"] = $role;

        $danhsach_phancong = [];
        $danhsach_chamcong = [];
        $search_da = trim($_GET["search_da"] ?? "");
        $search_cc = trim($_GET["search_cc"] ?? "");

        if ($role === "user") {
            // Lấy dự án phân công của user
            if (!empty($search_da)) {
                $stmt_pc = $pdo->prepare("
                    SELECT pc.*, da.tenduan, da.mota, da.ngaybatdau, da.ngayketthuc, da.status 
                    FROM phancong pc 
                    JOIN duan da ON pc.maduan = da.maduan 
                    WHERE pc.manhanvien = ? AND (da.tenduan LIKE ? OR pc.vaitro LIKE ?)
                ");
                $stmt_pc->execute([$manhanvien, "%{$search_da}%", "%{$search_da}%"]);
            } else {
                $stmt_pc = $pdo->prepare("
                    SELECT pc.*, da.tenduan, da.mota, da.ngaybatdau, da.ngayketthuc, da.status 
                    FROM phancong pc 
                    JOIN duan da ON pc.maduan = da.maduan 
                    WHERE pc.manhanvien = ?
                ");
                $stmt_pc->execute([$manhanvien]);
            }
            $danhsach_phancong = $stmt_pc->fetchAll(PDO::FETCH_ASSOC);

            // Lấy chấm công của user
            if (!empty($search_cc)) {
                $stmt_cc = $pdo->prepare("
                    SELECT * FROM chamcong 
                    WHERE manhanvien = ? AND (thang LIKE ? OR nam LIKE ?) 
                    ORDER BY nam DESC, thang DESC
                ");
                $stmt_cc->execute([$manhanvien, "%{$search_cc}%", "%{$search_cc}%"]);
            } else {
                $stmt_cc = $pdo->prepare("
                    SELECT * FROM chamcong 
                    WHERE manhanvien = ? 
                    ORDER BY nam DESC, thang DESC
                ");
                $stmt_cc->execute([$manhanvien]);
            }
            $danhsach_chamcong = $stmt_cc->fetchAll(PDO::FETCH_ASSOC);
        }

        // Nạp giao diện quản lý khi đã đăng nhập
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/dashboard.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}