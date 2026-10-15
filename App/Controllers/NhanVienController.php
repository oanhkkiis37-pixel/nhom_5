<?php
require_once __DIR__ . '/../Models/NhanVienModel.php';
require_once __DIR__ . '/../Models/PhongBanModel.php';

class NhanVienController {
    private $nvModel;
    private $pbModel;

    public function __construct() {
        $database = new db(); // Khởi tạo trực tiếp đối tượng chứa pdo trong model/database của bạn
        $this->nvModel = new NhanVienModel($database->pdo);
        $this->pbModel = new PhongBanModel($database->pdo);
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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

                // 1. Kiểm tra thông tin bắt buộc
                if (empty($data['hovaten']) || empty($data['username']) || empty($data['password'])) {
                    $error_msg = "Vui lòng điền đầy đủ các thông tin bắt buộc (Họ tên, Username, Password)!";
                }
                // 2. Kiểm tra tính hợp lệ của Ngày sinh
                elseif (!empty($data['ngaysinh'])) {
                    $parts = explode('-', $data['ngaysinh']);
                    if (count($parts) === 3) {
                        $nam = intval($parts[0]);
                        $thang = intval($parts[1]);
                        $ngay = intval($parts[2]);

                        if (!checkdate($thang, $ngay, $nam)) {
                            $error_msg = "Ngày sinh không hợp lệ trên thực tế (sai ngày trong tháng)!";
                        } elseif (strtotime($data['ngaysinh']) > time()) {
                            $error_msg = "Ngày sinh không được lớn hơn ngày hiện tại!";
                        }
                    } else {
                        $error_msg = "Định dạng ngày sinh không đúng!";
                    }
                }

                // 3. Kiểm tra trùng lặp Username
                if (empty($error_msg) && $this->nvModel->getByUsername($data['username'])) {
                    $error_msg = "Tên đăng nhập (Username) này đã tồn tại. Vui lòng chọn tên khác!";
                }

                // 4. Nếu KHÔNG CÓ LỖI, tiến hành thêm mới vào Database
                if (empty($error_msg)) {
                    if ($this->nvModel->add($data)) {
                        $success_msg = "Thêm nhân viên thành công!";
                    } else {
                        $error_msg = "Lỗi khi thêm nhân viên vào cơ sở dữ liệu!";
                    }
                }
            } 
            elseif ($action === "update") {
                // ... (phần xử lý update giữ nguyên như cũ của bạn)
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
                header("Location: index.php?controller=NhanVien&action=index");
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
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/layouts/nhanvien.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}