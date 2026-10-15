<?php

/** @var string $success_msg */
/** @var string $error_msg */
/** @var bool $edit_mode */
/** @var array $edit_nv */
/** @var array $danhsach_pb */
/** @var string $search_keyword */
/** @var array $danhsach_nv */
?>


<link rel="stylesheet" href="App/Views/css/style.css">

<div class="header">
    <h2>Quản lý Nhân viên</h2>
    <a href="index.php?controller=Dashboard&action=index" style="color: white; text-decoration: none;">Quay lại trang chủ</a>
</div>

<div class="container">

    <?php if ($success_msg): ?>
        <div class="alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div class="alert-danger"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <!-- Form Thêm / Sửa Nhân viên -->
    <div class="card">
        <h3><?php echo $edit_mode ? "Sửa thông tin nhân viên" : "Thêm nhân viên mới"; ?></h3>
        <form method="POST" action="index.php?controller=NhanVien&action=index">
            <input type="hidden" name="action" value="<?php echo $edit_mode ? "update" : "add"; ?>">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="manhanvien" value="<?php echo $edit_nv['manhanvien']; ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Họ và tên:</label>
                    <input type="text" name="hovaten" value="<?php echo htmlspecialchars($edit_nv['hovaten'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Ngày sinh:</label>
                    <input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($edit_nv['ngaysinh'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Số điện thoại:</label>
                    <input type="text" name="sdt" value="<?php echo htmlspecialchars($edit_nv['sdt'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Chức vụ:</label>
                    <input type="text" name="chucvu" value="<?php echo htmlspecialchars($edit_nv['chucvu'] ?? ''); ?>" placeholder="Ví dụ: Giám đốc, Nhân viên...">
                </div>

                <div class="form-group">
                    <label>Lương cơ bản:</label>
                    <input type="number" step="1000000" name="luongcoban" value="<?php echo htmlspecialchars($edit_nv['luongcoban'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Phòng ban:</label>
                    <select name="maphong">
                        <option value="">-- Chọn phòng ban --</option>
                        <?php foreach ($danhsach_pb as $pb): ?>
                            <option value="<?php echo $pb['maphong']; ?>" <?php echo (($edit_nv['maphong'] ?? '') == $pb['maphong']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pb['tenphong']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tên đăng nhập (Username):</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($edit_nv['username'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Mật khẩu (Password):</label>
                    <input type="password" name="password" placeholder="<?php echo $edit_mode ? 'Bỏ trống nếu không đổi mật khẩu' : 'Nhập mật khẩu'; ?>" <?php echo $edit_mode ? '' : 'required'; ?>>
                </div>
            </div>

            <button type="submit"><?php echo $edit_mode ? "Cập nhật" : "Thêm mới"; ?></button>
            <?php if ($edit_mode): ?>
                <a href="index.php?controller=NhanVien&action=index" style="margin-left: 10px; color: #6c757d; text-decoration: none; padding: 10px 15px; display: inline-block;">Hủy</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Danh sách nhân viên và Tìm kiếm -->
    <div class="card" style="margin-top: 30px;">
        <h3>Danh sách nhân viên</h3>
        
        <!-- Form Tìm kiếm -->
        <form method="GET" action="index.php" class="search-box">
            <input type="hidden" name="controller" value="NhanVien">
            <input type="hidden" name="action" value="index">
            <input type="text" name="search" placeholder="Nhập họ tên nhân viên cần tìm..." value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit" class="btn-search">Tìm kiếm</button>
            <?php if (!empty($search_keyword)): ?>
                <a href="index.php?controller=NhanVien&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ và tên</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Chức vụ</th>
                    <th>Lương cơ bản</th>
                    <th>Phòng ban</th>
                    <th>Username</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($danhsach_nv) > 0): ?>
                    <?php foreach ($danhsach_nv as $nv): ?>
                        <tr>
                            <td><?php echo $nv['manhanvien']; ?></td>
                            <td><?php echo htmlspecialchars($nv['hovaten'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($nv['ngaysinh'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($nv['sdt'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($nv['chucvu'] ?? ''); ?></td>
                            <td><?php echo number_format($nv['luongcoban'] ?? 0, 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($nv['tenphong'] ?? 'Chưa phân bổ'); ?></td>
                            <td><?php echo htmlspecialchars($nv['username'] ?? ''); ?></td>
                            <td>
                                <a href="index.php?controller=NhanVien&action=index&edit=<?php echo $nv['manhanvien']; ?>" class="btn-edit" style="color: #333; text-decoration: none; margin-right: 10px;">Sửa</a>
                                <a href="index.php?controller=NhanVien&action=index&delete=<?php echo $nv['manhanvien']; ?>" class="btn-delete" style="color: white; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">Không tìm thấy nhân viên phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>