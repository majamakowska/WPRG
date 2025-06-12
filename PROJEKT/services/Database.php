<?php
class Database {
    private static $instance = null;
    private $connection;
    private function __construct()
    {
        $this->connection = $this->connect();
    }
    public static function getInstanceOf() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function connect() {
        $servername = "127.0.0.1:3307";
        $username = "root";
        $password = "";
        $dbname = "forum";

        $connection = new mysqli($servername, $username, $password, $dbname);

        if ($connection->connect_error) {
            die("Połączenie nieudane: " . $this->connection->connect_error);
        }
        return $connection;
    }
    public function runQuery(string $query, array $params = [])
    {
        $stmt = $this->connection->prepare($query);

        $refs = [];
        if (!empty($params)) {
            $types = "";
            for ($i = 0; $i < count($params); $i++) {
                if (is_int($params[$i])) {
                    $types .= "i";
                } elseif (is_float($params[$i])) {
                    $types .= "d";
                } else {
                    $types .= "s";
                };
                $refs[$i] = &$params[$i];
            }
            $stmt->bind_param($types, ...$refs);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getLastInsertedId()
    {
        return $this->connection->insert_id;
    }
    public static function onDeleteCascade_posts($db) {
        $db->runQuery("DELETE FROM posts WHERE NOT EXISTS (SELECT 1 FROM categories WHERE categories.id = posts.category_id)");
        self::onDeleteCascade_comments($db);
    }
    public static function onDeleteCascade_comments($db) {
        $db->runQuery("DELETE FROM comments WHERE NOT EXISTS (SELECT 1 FROM posts WHERE posts.id = comments.post_id)");
    }
    public function close() {
        $this->connection->close();
        self::$instance = null;
    }
} ?>