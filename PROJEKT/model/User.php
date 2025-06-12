<?php
class User
{
    public static function checkRole($db) {
        if (isset($_SESSION['user_id'])) {
            return self::checkRoleById($db, $_SESSION['user_id']);
        } else return "guest";
    }
    public static function checkRoleById($db, $id) {
        if ($id != null) {
            $result = $db->runQuery("SELECT role FROM users WHERE id=?", [$id]);
            $row = $result->fetch_assoc();
            if ($row && $row['role'] != null) {
                return $row['role'];
            } else {
                return "user";
            }
        } else return "guest";
    }
} ?>