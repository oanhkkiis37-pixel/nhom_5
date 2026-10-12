<?php
require_once __DIR__ . '/../Models/DuAnModel.php';

class DuAnController {
    private $duAnModel;

    public function __construct($pdo) {
        // Kiểm tra đăng nhập (nếu index.php chưa kiểm tra chung)
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }
        $this->duAnModel = new DuAnModel($pdo);
    }

    public function index() {
        $success_msg = "";
        $error_msg = "";
        $edit_mode = false;
        $edit_da = [
            'maduan' => '',
            'tenduan' => '',
            'mota' => '',
            'ngaybatdau' => '',
            'ngayketthuc' => '',
            'status' => 'Planning'
        ];

        // Xử lý dữ liệu POST (Thêm hoặc Sửa)
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? "";

            if ($action === "add") {
                $data = [
                    'tenduan' => trim($_POST["tenduan"]),
                    'mota' => trim($_POST["mota"]),
                    'ngaybatdau' => trim($_POST["ngaybatdau"]),
                    'ngayketthuc' => trim($_POST["ngayketthuc"]),
                    'status' => trim($_POST["status"])
                ];

                if (!empty($data['tenduan'])) {
                    if ($this->duAnModel->add($data)) {
                        $success_msg = "Thêm dự án thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm dự án!";
                    }
                } else {
                    $error_msg = "Tên dự án không được để trống!";
                }
            } elseif ($action === "update") {
                $data = [
                    'maduan' => intval($_POST["maduan"]),
                    'tenduan' => trim($_POST["tenduan"]),
                    'mota' => trim($_POST["mota"]),
                    'ngaybatdau' => trim($_POST["ngaybatdau"]),
                    'ngayketthuc' => trim($_POST["ngayketthuc"]),
                    'status' => trim($_POST["status"])
                ];

                if (!empty($data['tenduan']) && $data['maduan'] > 0) {
                    if ($this->duAnModel->update($data)) {
                        $success_msg = "Cập nhật dự án thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật dự án!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa dự án
        if (isset($_GET["delete"])) {
            $maduan = intval($_GET["delete"]);
            if ($this->duAnModel->delete($maduan)) {
                header("Location: index.php?controller=DuAn&action=index");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa dự án!";
            }
        }

        // Lấy dữ liệu khi bấm nút Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $maduan = intval($_GET["edit"]);
            $edit_da = $this->duAnModel->getById($maduan);
        }

        // Tìm kiếm và lấy danh sách dự án
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_da = $this->duAnModel->getAll($search_keyword);

        // Nạp View hiển thị giao diện
        require_once __DIR__ . '/../Views/duan.php';
    }
}