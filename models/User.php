<?php
include_once __DIR__ . "/../config/db.php";

class User {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /**
     * إنشاء مستخدم جديد
     * @param string $username
     * @param string $password
     * @param string $role
     * @return bool
     */
    public function create($username, $password, $role = 'employee') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        return $stmt->execute();
    }

    /**
     * تحديث اسم المستخدم وكلمة المرور
     * @param string $oldUsername
     * @param string $newUsername
     * @return bool
     */
    public function updateUsername($oldUsername, $newUsername) {
        $hashedPassword = password_hash($newUsername, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET username=?, password=? WHERE username=?");
        $stmt->bind_param("sss", $newUsername, $hashedPassword, $oldUsername);
        return $stmt->execute();
    }

    /**
     * حذف مستخدم بواسطة اسم المستخدم
     * @param string $username
     * @return bool
     */
    public function deleteByUsername($username) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        return $stmt->execute();
    }

    /**
     * البحث عن مستخدم لتسجيل الدخول
     * @param string $username
     * @return array|null
     */
    public function findUser($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
