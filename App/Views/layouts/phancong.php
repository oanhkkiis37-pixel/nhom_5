<?php
require_once __DIR__ . '/../header.php';
?>
<link rel="stylesheet" href="App/Views/css/style.css">

<div class="header">
    <h2>Quản lý Phân công Dự án</h2>
    <a href="index.php?controller=Dashboard&action=index" style="color: white; text-decoration: none;">Quay lại trang chủ</a>
</div>

<div class="container">

    <?php if (!empty($success_msg)): ?>
        <div class="alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if (!empty($error_msg)): ?>
        <div class="alert-danger"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <!-- Form Thêm / Sửa Phân công -->
    <div class="card">
        <h3><?php echo $edit_mode ? "Sửa thông tin phân công" : "Thêm phân công mới"; ?></h3>
        <form method="POST" action="index.php?controller=PhanCong&action=index">
            <input type="hidden" name="action" value="<?php echo $edit_mode ? "update" : "add"; ?>">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="maphancong" value="<?php echo $edit_pc['maphancong']; ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nhân viên:</label>
                    <select name="manhanvien" required>
                        <option value="">-- Chọn nhân viên --</option>
                        <?php foreach ($danhsach_nv as $nv): ?>
                            <option value="<?php echo $nv['manhanvien']; ?>" <?php echo (($edit_pc['manhanvien'] ?? '') == $nv['manhanvien']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($nv['hovaten']); ?> (ID: <?php echo $nv['manhanvien']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Dự án:</label>
                    <select name="maduan" required>
                        <option value="">-- Chọn dự án --</option>
                        <?php foreach ($danhsach_da as $da): ?>
                            <option value="<?php echo $da['maduan']; ?>" <?php echo (($edit_pc['maduan'] ?? '') == $da['maduan']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($da['tenduan']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Vai trò:</label>
                    <input type="text" name="vaitro" value="<?php echo htmlspecialchars($edit_pc['vaitro'] ?? ''); ?>" placeholder="Ví dụ: Developer, Tester...">
                </div>

                <div class="form-group">
                    <label>Ngày tham gia:</label>
                    <input type="date" name="ngaythamgia" value="<?php echo htmlspecialchars($edit_pc['ngaythamgia'] ?? date('Y-m-d')); ?>">
                </div>
            </div>

            <button type="submit"><?php echo $edit_mode ? "Cập nhật" : "Thêm mới"; ?></button>
            <?php if ($edit_mode): ?>
                <a href="index.php?controller=PhanCong&action=index" style="margin-left: 10px; color: #6c757d; text-decoration: none; padding: 10px 15px; display: inline-block;">Hủy</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Danh sách phân công và Tìm kiếm -->
    <div class="card" style="margin-top: 30px;">
        <h3>Danh sách phân công</h3>
        
        <!-- Form Tìm kiếm -->
        <form method="GET" action="index.php" class="search-box">
            <input type="hidden" name="controller" value="PhanCong">
            <input type="hidden" name="action" value="index">
            <input type="text" name="search" placeholder="Nhập tên nhân viên hoặc dự án cần tìm..." value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit" class="btn-search">Tìm kiếm</button>
            <?php if (!empty($search_keyword)): ?>
                <a href="index.php?controller=PhanCong&action=index" style="background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Làm mới</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Mã PC</th>
                    <th>Nhân viên</th>
                    <th>Dự án</th>
                    <th>Vai trò</th>
                    <th>Ngày tham gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($danhsach_pc) > 0): ?>
                    <?php foreach ($danhsach_pc as $pc): ?>
                        <tr>
                            <td><?php echo $pc['maphancong']; ?></td>
                            <td><?php echo htmlspecialchars($pc['hovaten'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($pc['tenduan'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($pc['vaitro'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($pc['ngaythamgia'] ?? ''); ?></td>
                            <td>
                                <a href="index.php?controller=PhanCong&action=index&edit=<?php echo $pc['maphancong']; ?>" class="btn-edit" style="color: #007bff; text-decoration: none; margin-right: 10px;">Sửa</a>
                                <a href="index.php?controller=PhanCong&action=index&delete=<?php echo $pc['maphancong']; ?>" class="btn-delete" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa phân công này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Không tìm thấy phân công phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
require_once __DIR__ . '/../footer.php';
?>