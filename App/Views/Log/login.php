<?php
// App/Views/login.php
require_once __DIR__ . '/../header.php';
?>

<!-- Liên kết file CSS riêng biệt -->
<link rel="stylesheet" href="App/Views/css/login.css">

<div class="login-container">
    <form class="login-form" method="POST" action="index.php?controller=Login&action=index">
        <h2>Đăng nhập hệ thống</h2>
        
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <button type="submit">Đăng nhập</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../footer.php';
?>