<?php
class db{
    private string $host = 'localhost';
    private string $port = 3306;
    private string $db = 'nhom_5';
    private string $username = 'root';
    private string $password = '';

    public PDO $pdo;

    public function __construct(){
        $dsn = "mysql:host=$this->host; port=$this->port ; dsname=$this->db; charset=utf8mb4";

        try{
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            echo("kết nối thành công");
        }catch(PDOException $e){
            echo("Lỗi kết nối!" . $e->getMessage());
        }
    }
}
?>