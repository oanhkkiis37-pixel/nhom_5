<?php
// App/Controllers/PhanCongController.php

class PhanCongController {
    public function index() {
        // Kiểm tra đăng nhập và quyền Admin
        if (!isset($_SESSION["username"]) || ($_SESSION["role"] ?? '') !== "admin") {
            header("Location: index.php?controller=Login&action=index");
            exit();
        }

        $phanCongModel = new PhanCongModel();
        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_pc = [
            'maphancong' => '',
            'manhanvien' => '',
            'maduan' => '',
            'vaitro' => '',
            'ngaythamgia' => date('Y-m-d')
        ];

        // Xử lý Thêm / Sửa
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? "";

            if ($action === "add") {
                $manhanvien = intval($_POST["manhanvien"]);
                $maduan = intval($_POST["maduan"]);
                $vaitro = trim($_POST["vaitro"]);
                $ngaythamgia = trim($_POST["ngaythamgia"]);

                if ($manhanvien > 0 && $maduan > 0) {
                    if ($phanCongModel->add($manhanvien, $maduan, $vaitro, $ngaythamgia)) {
                        $success_msg = "Thêm phân công thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm phân công!";
                    }
                } else {
                    $error_msg = "Vui lòng chọn nhân viên và dự án hợp lệ!";
                }
            } elseif ($action === "update") {
                $maphancong = intval($_POST["maphancong"]);
                $manhanvien = intval($_POST["manhanvien"]);
                $maduan = intval($_POST["maduan"]);
                $vaitro = trim($_POST["vaitro"]);
                $ngaythamgia = trim($_POST["ngaythamgia"]);

                if ($maphancong > 0 && $manhanvien > 0 && $maduan > 0) {
                    if ($phanCongModel->update($maphancong, $manhanvien, $maduan, $vaitro, $ngaythamgia)) {
                        $success_msg = "Cập nhật phân công thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật phân công!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa
        if (isset($_GET["delete"])) {
            $maphancong = intval($_GET["delete"]);
            if ($phanCongModel->delete($maphancong)) {
                header("Location: index.php?controller=PhanCong&action=index");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa phân công!";
            }
        }

        // Xử lý Lấy dữ liệu để Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $maphancong = intval($_GET["edit"]);
            $result = $phanCongModel->getById($maphancong);
            if ($result) {
                $edit_pc = $result;
            }
        }

        // Lấy danh sách nhân viên, dự án và dữ liệu phân công kèm tìm kiếm
        $danhsach_nv = $phanCongModel->getNhanVienList();
        $danhsach_da = $phanCongModel->getDuAnList();
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_pc = $phanCongModel->getAll($search_keyword);

        // Nạp giao diện View qua các layout chuẩn
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/phancong.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}