<?php
// App/Controllers/ChamCongController.php

class ChamCongController {
    public function index() {
        // Kiểm tra quyền Admin
        if (!isset($_SESSION["username"]) || ($_SESSION["role"] ?? '') !== "admin") {
            header("Location: index.php?controller=Login&action=index");
            exit();
        }

        $chamCongModel = new ChamCongModel();
        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_cc = [
            'machamcong' => '',
            'manhanvien' => '',
            'thang' => date('n'),
            'nam' => date('Y'),
            'sogiolam' => 0,
            'phucap' => 0.00,
            'thuong' => 0.00
        ];

        // Xử lý Thêm / Sửa
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? "";

            if ($action === "add") {
                $manhanvien = intval($_POST["manhanvien"]);
                $thang = intval($_POST["thang"]);
                $nam = intval($_POST["nam"]);
                $sogiolam = intval($_POST["sogiolam"]);
                $phucap = floatval($_POST["phucap"]);
                $thuong = floatval($_POST["thuong"]);

                if ($manhanvien > 0 && $thang >= 1 && $thang <= 12 && $nam > 0) {
                    if ($chamCongModel->add($manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong)) {
                        $success_msg = "Thêm bảng chấm công thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm bảng chấm công!";
                    }
                } else {
                    $error_msg = "Vui lòng điền đầy đủ thông tin hợp lệ!";
                }
            } elseif ($action === "update") {
                $machamcong = intval($_POST["machamcong"]);
                $manhanvien = intval($_POST["manhanvien"]);
                $thang = intval($_POST["thang"]);
                $nam = intval($_POST["nam"]);
                $sogiolam = intval($_POST["sogiolam"]);
                $phucap = floatval($_POST["phucap"]);
                $thuong = floatval($_POST["thuong"]);

                if ($machamcong > 0 && $manhanvien > 0 && $thang >= 1 && $thang <= 12 && $nam > 0) {
                    if ($chamCongModel->update($machamcong, $manhanvien, $thang, $nam, $sogiolam, $phucap, $thuong)) {
                        $success_msg = "Cập nhật bảng chấm công thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật bảng chấm công!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa
        if (isset($_GET["delete"])) {
            $machamcong = intval($_GET["delete"]);
            if ($chamCongModel->delete($machamcong)) {
                header("Location: index.php?controller=ChamCong&action=index");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa bản ghi!";
            }
        }

        // Xử lý Lấy dữ liệu để Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $machamcong = intval($_GET["edit"]);
            $result = $chamCongModel->getById($machamcong);
            if ($result) {
                $edit_cc = $result;
            }
        }

        // Lấy danh sách nhân viên và dữ liệu chấm công kèm tìm kiếm
        $danhsach_nv = $chamCongModel->getNhanVienList();
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_cc = $chamCongModel->getAll($search_keyword);

        // Nạp giao diện View thông qua layouts
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/chamcong.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}