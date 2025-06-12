<?php
class User
{
    public static function checkRole($db) {
        if (isset($_SESSION['user_id'])) {
            $result = $db->runQuery("SELECT role FROM users WHERE id=?", [$_SESSION['user_id']]);
            return $result->fetch_assoc()['role'];
        } else return "guest";
    }
    public static function checkRoleById($db, $id) {
        if ($id != null) {
            $result = $db->runQuery("SELECT role FROM users WHERE id=?", [$id]);
            return $result->fetch_assoc()['role'];
        } else return "guest";
    }
} ?>