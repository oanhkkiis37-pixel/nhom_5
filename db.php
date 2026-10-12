<?php
class db {
    private string $host = 'localhost';
    private int $port = 3306;
    private string $db = 'nhom_5';
    private string $username = 'root';
    private string $password = '';

    public PDO $pdo;

    public function __construct() {
        
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            
            // Thiết lập chế độ báo lỗi exception & trả về mảng kết hợp
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }
}
?>