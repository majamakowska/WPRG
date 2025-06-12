<?php
class User
{
    public static function checkRole($db) {
        if (isset($_SESSION['user_id'])) {
            $result = $db->runQuery("SELECT role FROM users WHERE id=?", [$_SESSION['user_id']]);
            if ($result->fetch_assoc()['role'] != null) {
                return $result->fetch_assoc()['role'];
            } else return "user";
        } else return "guest";
    }
    public static function checkRoleById($db, $id) {
        if ($id != null) {
            $result = $db->runQuery("SELECT role FROM users WHERE id=?", [$id]);
            if ($result->fetch_assoc()['role'] != null) {
                return $result->fetch_assoc()['role'];
            } else return "user";
        } else return "guest";
    }
} ?>