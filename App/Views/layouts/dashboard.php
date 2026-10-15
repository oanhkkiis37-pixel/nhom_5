<?php
require_once __DIR__ . '/../header.php';
/** @var string $hovaten */
/** @var string $chucvu */
/** @var string $role */
/** @var string $search_da */
/** @var array $danhsach_phancong */
/** @var string $search_cc */
/** @var array $danhsach_chamcong */
/** @var float $luongcoban */
?>
require_once __DIR__ . '/../header.php';
?>
<link rel="stylesheet" href="App/Views/css/dashboard.css">


    <div class="header">
        <h2>CÔNG TY 4</h2>
        <div class="user-info">
            Xin chào: <strong><?php echo htmlspecialchars($hovaten); ?></strong>
            <br>
            Chức vụ: <strong><?php echo htmlspecialchars($chucvu); ?></strong>
            <br><br>
            <a class="logout" href="index.php?controller=Login&action=logout">Đăng xuất</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h1>Xin chào <?php echo htmlspecialchars($hovaten); ?>!</h1>
            <p>
                Bạn đang đăng nhập với quyền hạn hệ thống:
                <span class="role">
                    <?php echo strtoupper(htmlspecialchars($role)); ?>
                </span>
            </p>
        </div>

        <?php if ($role === "admin"): ?>
            <h2>Chức năng Admin</h2>
            <div class="menu">
                <a href="index.php?controller=PhongBan&action=index" class="menu-item">
                    <h3>Quản lý phòng ban</h3>
                    <p>Quản lý phòng ban trong hệ thống.</p>
                </a>
                <a href="index.php?controller=NhanVien&action=index" class="menu-item">
                    <h3>Quản lý nhân viên</h3>
                    <p>Thêm, sửa, xóa nhân viên.</p>
                </a>
                <a href="index.php?controller=DuAn&action=index" class="menu-item">
                    <h3>Quản lý dự án</h3>
                    <p>Xem thông tin, báo cáo và thống kê dự án.</p>
                </a>
                <a href="index.php?controller=PhanCong&action=index" class="menu-item">
                    <h3>Quản lý phân công</h3>
                    <p>Quản lý và phân công công việc, dự án.</p>
                </a>
                <a href="index.php?controller=ChamCong&action=index" class="menu-item">
                    <h3>Quản lý chấm công và tiền lương</h3>
                    <p>Thống kê chấm công, bảng lương của nhân viên.</p>
                </a>
            </div>

<!-- ========================================================================================================================================= -->
            
        <?php else: ?>
            <!-- Giao diện dành cho User (Chỉ xem) -->
            <div class="card">
                <h3>Dự án đã được phân công</h3>
                
                <form method="GET" action="index.php" class="search-box">
                    <input type="hidden" name="controller" value="Dashboard">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search_da" placeholder="Tìm theo tên dự án hoặc vai trò..." value="<?php echo htmlspecialchars($search_da); ?>">
                    <button type="submit" class="btn-search">Tìm kiếm</button>
                    <?php if (!empty($search_da)): ?>
                        <a href="index.php?controller=Dashboard&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
                    <?php endif; ?>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Mã DA</th>
                            <th>Tên dự án</th>
                            <th>Vai trò</th>
                            <th>Ngày tham gia</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($danhsach_phancong) > 0): ?>
                            <?php foreach ($danhsach_phancong as $pc): ?>
                                <tr>
                                    <td><?php echo $pc['maduan']; ?></td>
                                    <td><?php echo htmlspecialchars($pc['tenduan'] ?? ''); ?></td>
                                    <td><strong><?php echo htmlspecialchars($pc['vaitro'] ?? ''); ?></strong></td>
                                    <td><?php echo htmlspecialchars($pc['ngaythamgia'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($pc['status'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Bạn chưa được phân công tham gia dự án nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h3>Bảng chấm công & Lương thưởng hàng tháng</h3>
                
                <form method="GET" action="index.php" class="search-box">
                    <input type="hidden" name="controller" value="Dashboard">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search_cc" placeholder="Tìm theo tháng hoặc năm..." value="<?php echo htmlspecialchars($search_cc); ?>">
                    <button type="submit" class="btn-search">Tìm kiếm</button>
                    <?php if (!empty($search_cc)): ?>
                        <a href="index.php?controller=Dashboard&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
                    <?php endif; ?>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Tháng/Năm</th>
                            <th>Số giờ làm</th>
                            <th>Lương cơ bản</th>
                            <th>Phụ cấp</th>
                            <th>Thưởng</th>
                            <th>Tổng lương</th>
                            <th>Cập nhật gần nhất</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($danhsach_chamcong) > 0): ?>
                            <?php foreach ($danhsach_chamcong as $cc): 
                                $phucap = floatval($cc['phucap'] ?? 0);
                                $thuong = floatval($cc['thuong'] ?? 0);
                                $tongluong = $luongcoban + $phucap + $thuong;
                            ?>
                                <tr>
                                    <td><?php echo $cc['thang'] . '/' . $cc['nam']; ?></td>
                                    <td><?php echo htmlspecialchars($cc['sogiolam'] ?? 0); ?> giờ</td>
                                    <td><?php echo number_format($luongcoban, 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo number_format($phucap, 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo number_format($thuong, 0, ',', '.'); ?> VNĐ</td>
                                    <td><strong><?php echo number_format($tongluong, 0, ',', '.'); ?> VNĐ</strong></td>
                                    <td><?php echo htmlspecialchars($cc['ngaycapnhat'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Chưa có dữ liệu chấm công và lương cho tài khoản của bạn.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?php
require_once __DIR__ . '/../footer.php';
?>