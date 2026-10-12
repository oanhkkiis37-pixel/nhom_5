<?php
require_once __DIR__ . '/../Models/NhanVienModel.php';
require_once __DIR__ . '/../Models/PhongBanModel.php';

class NhanVienController {
    private $nvModel;
    private $pbModel;

    public function __construct($pdo) {
        $this->nvModel = new NhanVienModel($pdo);
        $this->pbModel = new PhongBanModel($pdo);
    }

    public function index() {
        session_start();
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_nv = [
            'manhanvien' => '', 'hovaten' => '', 'ngaysinh' => '', 
            'sdt' => '', 'chucvu' => '', 'luongcoban' => '',
            'maphong' => '', 'username' => '', 'password' => ''
        ];

        // Xử lý POST (Thêm / Sửa)
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
                    if ($this->nvModel->add($data)) {
                        $success_msg = "Thêm nhân viên thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm nhân viên!";
                    }
                } else {
                    $error_msg = "Vui lòng điền đầy đủ các thông tin bắt buộc!";
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
                    if ($this->nvModel->update($data)) {
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
            if ($this->nvModel->delete($manhanvien)) {
                header("Location: index.php?controller=nhanvien");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa nhân viên!";
            }
        }

        // Xử lý Sửa (Lấy dữ liệu cũ đổ vào form)
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $manhanvien = intval($_GET["edit"]);
            $edit_nv = $this->nvModel->getById($manhanvien);
        }

        // Lấy danh sách phòng ban và nhân viên (có hỗ trợ tìm kiếm)
        $danhsach_pb = $this->pbModel->getAll();
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_nv = $this->nvModel->getAll($search_keyword);

        // Gọi View và truyền dữ liệu sang
        require_once "views/nhanvien/index.php";
    }
}