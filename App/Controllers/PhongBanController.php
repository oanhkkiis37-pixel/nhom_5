<?php
require_once __DIR__ . '/../Models/PhongBanModel.php';

class PhongBanController {
    private $model;

    public function __construct($pdo) {
        $this->model = new PhongBanModel($pdo);
    }

    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_phong = ['maphong' => '', 'tenphong' => '', 'sonhanvien' => ''];

        // Xử lý CRUD (Thêm / Sửa)
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? "";

            if ($action === "add") {
                $tenphong = trim($_POST["tenphong"]);
                $sonhanvien = intval($_POST["sonhanvien"]);

                if (!empty($tenphong)) {
                    if ($this->model->add($tenphong, $sonhanvien)) {
                        $success_msg = "Thêm phòng ban thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm phòng ban!";
                    }
                } else {
                    $error_msg = "Tên phòng ban không được để trống!";
                }
            } elseif ($action === "update") {
                $maphong = intval($_POST["maphong"]);
                $tenphong = trim($_POST["tenphong"]);
                $sonhanvien = intval($_POST["sonhanvien"]);

                if (!empty($tenphong) && $maphong > 0) {
                    if ($this->model->update($maphong, $tenphong, $sonhanvien)) {
                        $success_msg = "Cập nhật phòng ban thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật phòng ban!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa
        if (isset($_GET["delete"])) {
            $maphong = intval($_GET["delete"]);
            if ($this->model->delete($maphong)) {
                header("Location: phongban.php");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa phòng ban!";
            }
        }

        // Xử lý Lấy dữ liệu để Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $maphong = intval($_GET["edit"]);
            $edit_phong = $this->model->getById($maphong);
        }

        // Xử lý Tìm kiếm và Lấy danh sách
        $search_keyword = trim($_GET["search"] ?? "");
        if (!empty($search_keyword)) {
            $danhsach = $this->model->search($search_keyword);
        } else {
            $danhsach = $this->model->getAll();
        }

        // Gọi View để hiển thị giao diện
        include __DIR__ . '/../../Views/phongban.php';
    }
}
?>