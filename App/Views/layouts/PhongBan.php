<?php
/** @var array $edit_phong */
/** @var bool $edit_mode */
/** @var array $danhsach */
/** @var string $search_keyword */
/** @var string $success_msg */
/** @var string $error_msg */

require_once __DIR__ . '/../header.php';
?>
<link rel="stylesheet" href="App/Views/css/style.css">

<div class="header">
    <h2>Quản lý Phòng ban</h2>
    <a href="giaodien.php">Quay lại trang chủ</a>
</div>

<div class="container">

    <?php if (!empty($success_msg)): ?>
        <div class="alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if (!empty($error_msg)): ?>
        <div class="alert-danger"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <!-- Form Thêm / Sửa -->
    <div class="card">
        <h3><?php echo $edit_mode ? "Sửa thông tin phòng ban" : "Thêm phòng ban mới"; ?></h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="<?php echo $edit_mode ? "update" : "add"; ?>">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="maphong" value="<?php echo $edit_phong['maphong']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Tên phòng ban:</label>
                <input type="text" name="tenphong" value="<?php echo htmlspecialchars($edit_phong['tenphong'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Số lượng nhân viên:</label>
                <input type="number" name="sonhanvien" value="<?php echo htmlspecialchars($edit_phong['sonhanvien'] ?? ''); ?>">
            </div>

            <button type="submit"><?php echo $edit_mode ? "Cập nhật" : "Thêm mới"; ?></button>
            <?php if ($edit_mode): ?>
                <a href="phongban.php" style="margin-left: 10px; color: #6c757d; text-decoration: none;">Hủy</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Danh sách phòng ban và Tìm kiếm -->
    <div class="card">
        <h3>Danh sách phòng ban</h3>
        
        <form method="GET" action="" class="search-box">
            <input type="text" name="search" placeholder="Nhập tên phòng ban cần tìm..." value="<?php echo htmlspecialchars($search_keyword ?? ''); ?>">
            <button type="submit" class="btn-search">Tìm kiếm</button>
            <?php if (!empty($search_keyword)): ?>
                <a href="phongban.php" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Mã phòng</th>
                    <th>Tên phòng ban</th>
                    <th>Số nhân viên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($danhsach) && count($danhsach) > 0): ?>
                    <?php foreach ($danhsach as $pb): ?>
                        <tr>
                            <td><?php echo $pb['maphong']; ?></td>
                            <td><?php echo htmlspecialchars($pb['tenphong']); ?></td>
                            <td><?php echo $pb['sonhanvien']; ?></td>
                            <td>
                                <a href="phongban.php?edit=<?php echo $pb['maphong']; ?>" class="btn-edit">Sửa</a>
                                <a href="phongban.php?delete=<?php echo $pb['maphong']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng ban này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Không tìm thấy phòng ban phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>