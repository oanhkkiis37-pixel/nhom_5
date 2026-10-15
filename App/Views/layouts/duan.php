<?php
/**
 * @var string $success_msg
 * @var string $error_msg
 * @var bool $edit_mode
 * @var array $edit_da
 * @var array $danhsach_da
 * @var string $search_keyword
 */

?>
<link rel="stylesheet" href="App/Views/css/style.css">

<div class="header">
    <h2>Quản lý Dự án</h2>
    <a href="index.php?controller=Dashboard&action=index" style="color: white; text-decoration: none;">Quay lại trang chủ</a>
</div>

<div class="container">

    <?php if (!empty($success_msg)): ?>
        <div class="alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if (!empty($error_msg)): ?>
        <div class="alert-danger"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <!-- Form Thêm / Sửa Dự án -->
    <div class="card">
        <h3><?php echo $edit_mode ? "Sửa thông tin dự án" : "Thêm dự án mới"; ?></h3>
        <form method="POST" action="index.php?controller=DuAn&action=index">
            <input type="hidden" name="action" value="<?php echo $edit_mode ? "update" : "add"; ?>">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="maduan" value="<?php echo $edit_da['maduan']; ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Tên dự án:</label>
                    <input type="text" name="tenduan" value="<?php echo htmlspecialchars($edit_da['tenduan'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select name="status">
                        <option value="Planning" <?php echo (($edit_da['status'] ?? '') === 'Planning') ? 'selected' : ''; ?>>Planning</option>
                        <option value="In Progress" <?php echo (($edit_da['status'] ?? '') === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo (($edit_da['status'] ?? '') === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?php echo (($edit_da['status'] ?? '') === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu:</label>
                    <input type="date" name="ngaybatdau" value="<?php echo htmlspecialchars($edit_da['ngaybatdau'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Ngày kết thúc:</label>
                    <input type="date" name="ngayketthuc" value="<?php echo htmlspecialchars($edit_da['ngayketthuc'] ?? ''); ?>">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả:</label>
                    <textarea name="mota" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-family: 'Times New Roman', Times, serif;"><?php echo htmlspecialchars($edit_da['mota'] ?? ''); ?></textarea>
                </div>
            </div>

            <button type="submit"><?php echo $edit_mode ? "Cập nhật" : "Thêm mới"; ?></button>
            <?php if ($edit_mode): ?>
                <a href="index.php?controller=DuAn&action=index" style="margin-left: 10px; color: #6c757d; text-decoration: none; padding: 10px 15px; display: inline-block;">Hủy</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Danh sách dự án và Tìm kiếm -->
    <div class="card" style="margin-top: 30px;">
        <h3>Danh sách dự án</h3>
        
        <form method="GET" action="index.php" class="search-box">
            <input type="hidden" name="controller" value="DuAn">
            <input type="hidden" name="action" value="index">
            <input type="text" name="search" placeholder="Nhập tên dự án cần tìm..." value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit" class="btn-search">Tìm kiếm</button>
            <?php if (!empty($search_keyword)): ?>
                <a href="index.php?controller=DuAn&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Mã DA</th>
                    <th>Tên dự án</th>
                    <th>Mô tả</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($danhsach_da) > 0): ?>
                    <?php foreach ($danhsach_da as $da): ?>
                        <tr>
                            <td><?php echo $da['maduan']; ?></td>
                            <td><?php echo htmlspecialchars($da['tenduan'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($da['mota'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($da['ngaybatdau'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($da['ngayketthuc'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($da['status'] ?? ''); ?></td>
                            <td>
                                <a href="index.php?controller=DuAn&action=index&edit=<?php echo $da['maduan']; ?>" class="btn-edit" style="color: #007bff; text-decoration: none; margin-right: 10px;">Sửa</a>
                                <a href="index.php?controller=DuAn&action=index&delete=<?php echo $da['maduan']; ?>" class="btn-delete" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa dự án này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Không tìm thấy dự án phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
require_once __DIR__ . '/../footer.php';
?>