<?php
class DuAnController {
    private $duanModel;
  public function __construct() {
    $database = new db(); // Khởi tạo trực tiếp đối tượng chứa pdo trong model/database của bạn
    $this->duanModel = new DuAnModel($database->pdo);
   
    }

    public function index() {
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

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

        // Xử lý POST (Thêm / Sửa)
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
                    if ($this->duanModel->add($data)) {
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
                    if ($this->duanModel->update($data)) {
                        $success_msg = "Cập nhật dự án thành công!";
                    } else {
                        $error_msg = "Lỗi khi cập nhật dự án!";
                    }
                } else {
                    $error_msg = "Dữ liệu không hợp lệ!";
                }
            }
        }

        // Xử lý Xóa
        if (isset($_GET["delete"])) {
            $maduan = intval($_GET["delete"]);
            if ($this->duanModel->delete($maduan)) {
                header("Location: index.php?controller=DuAn&action=index");
                exit();
            } else {
                $error_msg = "Lỗi khi xóa dự án!";
            }
        }

        // Lấy dữ liệu Sửa
        if (isset($_GET["edit"])) {
            $edit_mode = true;
            $maduan = intval($_GET["edit"]);
            $edit_da = $this->duanModel->getById($maduan);
        }

        // Tìm kiếm và lấy danh sách
        $search_keyword = trim($_GET["search"] ?? "");
        $danhsach_da = $this->duanModel->getAll($search_keyword);

        // Gọi View hiển thị
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/duan.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}