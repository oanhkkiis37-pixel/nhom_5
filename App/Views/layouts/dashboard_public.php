<?php
require_once __DIR__ . '/../header.php';
?>
<link rel="stylesheet" href="App/Views/css/dashboard.css">
    <!-- Thanh điều hướng trên cùng -->
    <div class="navbar">
        <h1>CÔNG TY 4</h1>
        <div class="nav-buttons">
            <button class="btn btn-apply" onclick="thongBaoBaoTri()">Ứng tuyển ngay</button>
            <a href="index.php?controller=Login&action=index" class="btn btn-login">Đăng nhập</a>
        </div>
    </div>

    <div class="container">
        <!-- Giới thiệu công ty -->
        <div class="section">
            <h2>Giới thiệu về CÔNG TY 4</h2>
            <p>Chúng tôi chuyên cung cấp các giải pháp công nghệ tiên tiến, phát triển phần mềm doanh nghiệp và quản lý hạ tầng hệ thống nội bộ đạt chuẩn quốc tế.</p>
            <p><strong>Địa chỉ:</strong> Số 18, Đường 36, Quận 67, TP. Hồ Chí Minh<br>
               <strong>Email:</strong> congty4@gmail.com | <strong>Điện thoại:</strong> 0367 367 367</p>
        </div>

        <!-- Sơ đồ tổ chức công ty (Dựa theo dữ liệu phòng ban của bạn) -->
        <div class="section">
            <h2>Sơ đồ tổ chức công ty</h2>
            <div class="org-chart">
                <!-- Cấp cao nhất -->
                <div class="org-level-1">Phòng Giám Đốc</div>
                
                <!-- Mũi tên giả lập / Khoảng cách -->
                <div style="font-weight: bold; color: #6c757d;">↓</div>

                <!-- Các phòng ban trực thuộc -->
                <div class="org-level-2-container">
                    <div class="org-level-2">
                        <h4>Phòng Kỹ Thuật (IT)</h4>
                        <p>Phát triển phần mềm & hạ tầng</p>
                    </div>
                    <div class="org-level-2">
                        <h4>Phòng Nhân Sự (HR)</h4>
                        <p>Tuyển dụng & quản lý nhân sự</p>
                    </div>
                    <div class="org-level-2">
                        <h4>Phòng Kinh Doanh (Sales)</h4>
                        <p>Khai thác thị trường & khách hàng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script thông báo bảo trì khi bấm nút ứng tuyển -->
    <script>
        function thongBaoBaoTri() {
            alert("Chức năng đang bảo trì, vui lòng quay lại sau!");
        }
    </script>

<?php
require_once __DIR__ . '/../footer.php';
?>

