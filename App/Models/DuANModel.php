<?php
class DuAnModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($keyword = '') {
        if (!empty($keyword)) {
            $stmt = $this->pdo->prepare("SELECT * FROM duan WHERE tenduan LIKE ?");
            $stmt->execute(["%" . $keyword . "%"]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM duan");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM duan WHERE maduan = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO duan (tenduan, mota, ngaybatdau, ngayketthuc, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['tenduan'], 
            $data['mota'], 
            $data['ngaybatdau'], 
            $data['ngayketthuc'], 
            $data['status']
        ]);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE duan SET tenduan = ?, mota = ?, ngaybatdau = ?, ngayketthuc = ?, status = ? WHERE maduan = ?");
        return $stmt->execute([
            $data['tenduan'], 
            $data['mota'], 
            $data['ngaybatdau'], 
            $data['ngayketthuc'], 
            $data['status'], 
            $data['maduan']
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM duan WHERE maduan = ?");
        return $stmt->execute([$id]);
    }
}