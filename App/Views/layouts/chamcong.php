<?php
require_once __DIR__ . '/../header.php';
?>
<link rel="stylesheet" href="App/Views/css/style.css">


<div class="header">
    <h2>Quản lý Chấm công & Lương thưởng</h2>
    <a href="index.php?controller=Dashboard&action=index" style="color: white; text-decoration: none;">Quay lại trang chủ</a>
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
        <h3><?php echo $edit_mode ? "Sửa thông tin chấm công" : "Thêm bản ghi chấm công mới"; ?></h3>
        <form method="POST" action="index.php?controller=ChamCong&action=index">
            <input type="hidden" name="action" value="<?php echo $edit_mode ? "update" : "add"; ?>">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="machamcong" value="<?php echo $edit_cc['machamcong']; ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nhân viên:</label>
                    <select name="manhanvien" required>
                        <option value="">-- Chọn nhân viên --</option>
                        <?php foreach ($danhsach_nv as $nv): ?>
                            <option value="<?php echo $nv['manhanvien']; ?>" <?php echo (($edit_cc['manhanvien'] ?? '') == $nv['manhanvien']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($nv['hovaten']); ?> (ID: <?php echo $nv['manhanvien']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tháng:</label>
                    <select name="thang" required>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo $m; ?>" <?php echo (($edit_cc['thang'] ?? date('n')) == $m) ? 'selected' : ''; ?>>
                                Tháng <?php echo $m; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Năm:</label>
                    <input type="number" name="nam" value="<?php echo htmlspecialchars($edit_cc['nam'] ?? date('Y')); ?>" required>
                </div>

                <div class="form-group">
                    <label>Số giờ làm:</label>
                    <input type="number" name="sogiolam" value="<?php echo htmlspecialchars($edit_cc['sogiolam'] ?? 0); ?>">
                </div>

                <div class="form-group">
                    <label>Phụ cấp:</label>
                    <input type="number" step="0.01" name="phucap" value="<?php echo htmlspecialchars($edit_cc['phucap'] ?? 0); ?>">
                </div>

                <div class="form-group">
                    <label>Thưởng:</label>
                    <input type="number" step="0.01" name="thuong" value="<?php echo htmlspecialchars($edit_cc['thuong'] ?? 0); ?>">
                </div>
            </div>

            <button type="submit"><?php echo $edit_mode ? "Cập nhật" : "Thêm mới"; ?></button>
            <?php if ($edit_mode): ?>
                <a href="index.php?controller=ChamCong&action=index" style="margin-left: 10px; color: #6c757d; text-decoration: none; padding: 10px 15px; display: inline-block;">Hủy</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Danh sách -->
    <div class="card" style="margin-top: 30px;">
        <h3>Danh sách chấm công & Lương</h3>
        
        <form method="GET" action="index.php" class="search-box">
            <input type="hidden" name="controller" value="ChamCong">
            <input type="hidden" name="action" value="index">
            <input type="text" name="search" placeholder="Nhập tên nhân viên, tháng hoặc năm..." value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit" class="btn-search">Tìm kiếm</button>
            <?php if (!empty($search_keyword)): ?>
                <a href="index.php?controller=ChamCong&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Mã CC</th>
                    <th>Nhân viên</th>
                    <th>Tháng/Năm</th>
                    <th>Số giờ làm</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Thưởng</th>
                    <th>Tổng lương</th>
                    <th>Cập nhật gần nhất</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($danhsach_cc) > 0): ?>
                    <?php foreach ($danhsach_cc as $cc): 
                        $luongcoban = floatval($cc['luongcoban'] ?? 0);
                        $phucap = floatval($cc['phucap'] ?? 0);
                        $thuong = floatval($cc['thuong'] ?? 0);
                        $tongluong = $luongcoban + $phucap + $thuong;
                    ?>
                        <tr>
                            <td><?php echo $cc['machamcong']; ?></td>
                            <td><?php echo htmlspecialchars($cc['hovaten'] ?? ''); ?></td>
                            <td><?php echo $cc['thang'] . '/' . $cc['nam']; ?></td>
                            <td><?php echo htmlspecialchars($cc['sogiolam'] ?? 0); ?> giờ</td>
                            <td><?php echo number_format($luongcoban, 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo number_format($phucap, 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo number_format($thuong, 0, ',', '.'); ?> VNĐ</td>
                            <td><strong><?php echo number_format($tongluong, 0, ',', '.'); ?> VNĐ</strong></td>
                            <td><?php echo htmlspecialchars($cc['ngaycapnhat'] ?? ''); ?></td>
                            <td>
                                <a href="index.php?controller=ChamCong&action=index&edit=<?php echo $cc['machamcong']; ?>" class="btn-edit" style="color: #007bff; text-decoration: none; margin-right: 10px;">Sửa</a>
                                <a href="index.php?controller=ChamCong&action=index&delete=<?php echo $cc['machamcong']; ?>" class="btn-delete" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center;">Không tìm thấy bản ghi chấm công phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
require_once __DIR__ . '/../footer.php';
?>