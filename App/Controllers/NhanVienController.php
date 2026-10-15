<?php
// App/Controllers/NhanVienController.php

class NhanVienController {
    public function index() {
        // Kiểm tra đăng nhập và quyền Admin
        if (!isset($_SESSION["username"]) || ($_SESSION["role"] ?? '') !== "admin") {
            header("Location: index.php?controller=Login&action=index");
            exit();
        }

        $nhanVienModel = new NhanVienModel();
        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_nv = [
            'manhanvien' => '', 
            'hovaten' => '', 
            'ngaysinh' => '', 
            'sdt' => '', 
            'chucvu' => '', 
            'luongcoban' => '',
            'maphong' => '', 
            'username' => '', 
            'password' => ''
        ];

        // Xử lý Thêm / Sửa
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? "";

            if ($action === "add") {
                $data = [
                    'hovaten' => trim($_POST["hovaten"]),
                    'ngaysinh' => trim($_POST["ngaysinh"]),
                    'sdt' => trim($_POST["sdt"]),
                    'chucvu' => trim($_POST["chucvu"]),
                    'luongcoban' => trim($_POST["luongcoban"]),
                    'maphong' => intval($_POST["maphong"]),
                    'username' => trim($_POST["username"]),
                    'password' => trim($_POST["password"])
                ];

                if (!empty($data['hovaten']) && !empty($data['username']) && !empty($data['password'])) {
                    if ($nhanVienModel->add($data)) {
                        $success_msg = "Thêm nhân viên thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm nhân viên!";
                    }
                } else {
                    $error_msg = "Vui lòng điền đầy đủ các thông tin bắt buộc (Họ tên, Username, Password)!";
                }
            } elseif ($action === "update") {
                $data = [
                    'manhanvien' => intval($_POST["manhanvien"]),
                    'hovaten' => trim($_POST["hovaten"]),
                    'ngaysinh' => trim($_POST["ngaysinh"]),
                    'sdt' => trim($_POST["sdt"]),
                    'chucvu' => trim($_POST["chucvu"]),
                    'luongcoban' => trim($_POST["luongcoban"]),
                    'maphong' => intval($_POST["maphong"]),
                    'username' => trim($_POST["username"]),
                    'password' => trim($_POST["password"])
                ];

                if (!empty($data['hovaten']) && $data['manhanvien'] > 0) {
                    $hasPassword = !empty($data['password']);
                    if ($nhanVienModel->update($data, $hasPassword)) {
                        $success_msg = "Cập nhật nhân viên thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật nhân viên!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa
        if (isset($_GET["delete"])) {
            $manhanvien = intval($_GET["delete"]);
            if ($nhanVienModel->delete($manhanvien)) {
                header("Location: index.php?controller=NhanVien&action=index");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa nhân viên!";
            }
        }

        // Xử lý Lấy dữ liệu để Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $manhanvien = intval($_GET["edit"]);
            $result = $nhanVienModel->getById($manhanvien);
            if ($result) {
                $edit_nv = $result;
            }
        }

        // Lấy danh sách phòng ban và danh sách nhân viên kèm tìm kiếm
        $danhsach_pb = $nhanVienModel->getPhongBanList();
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_nv = $nhanVienModel->getAll($search_keyword);

        // Nạp giao diện View qua các layout chuẩn
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/nhanvien.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}
