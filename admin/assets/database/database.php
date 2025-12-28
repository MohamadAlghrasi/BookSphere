

<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $db   = 'booksphere_db';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';

    // 👇 Private constructor to prevent multiple instances
    private function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    // 🧱 Singleton accessor
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // 🧪 Query runner method
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    public function lastInsertId() {
    return $this->conn->lastInsertId();
}
}



// $db = Database::getInstance();

// // $db->query("INSERT INTO users (name, email) VALUES (?, ?)", ['John', 'john@example.com']);


// // 📝 Select example
// $result = $db->query("SELECT * FROM users ");
// $user = $result->fetch();
// print_r($user);
?>
