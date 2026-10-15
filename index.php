<?php
// 1. Hiển thị báo lỗi trong môi trường phát triển (Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Khởi tạo Session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Nạp file kết nối CSDL chung
require_once __DIR__ . '/db.php';

// 4. Autoload tự động nạp các file Controller và Model trong thư mục App
spl_autoload_register(function ($className) {
    $directories = [
        __DIR__ . '/App/Controllers/',
        __DIR__ . '/App/Models/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 5. Lấy tham số điều hướng từ URL (Mặc định gọi DashboardController nếu không truyền gì)
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'DashboardController';
$actionName     = isset($_GET['action']) ? $_GET['action'] : 'index';

// 6. Kiểm tra và gọi Controller/Action tương ứng
if (class_exists($controllerName)) {
    $controller = new $controllerName();
   
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        echo "Phương thức <b>{$actionName}</b> không tồn tại trong controller <b>{$controllerName}</b>.";
    }
} else {
    echo "Controller <b>{$controllerName}</b> không tồn tại.";
}