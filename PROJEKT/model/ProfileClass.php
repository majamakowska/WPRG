<?php

class ProfileClass
{
    private $username;
    private $pfp;

    public function __construct($db, $user_id)
    {
        $result = $db->runQuery("SELECT username, pfp FROM profiles WHERE user_id=?", [$user_id]);
        $row = $result->fetch_assoc();
        $this->username = $row['username'];
        $this->pfp = self::getPfp($db, $user_id);
    }

    public static function getUsername($db, $user_id)
    {
        return $db->runQuery("SELECT username FROM profiles WHERE user_id=?", [$user_id])->fetch_assoc()["username"];
    }

    public static function getPfp($db, $user_id)
    {
        $result = $db->runQuery("SELECT pfp FROM profiles WHERE user_id=?", [$user_id]);
        $pfp = $result->fetch_assoc()['pfp'];
        if ($pfp == null) {
            $pfp = "profilePicturesDir/default_pfp.png";
        }
        return $pfp;
    }

    public static function ownProfile() : bool
    {
        return isset($_GET['user_id']) && isset($_SESSION['user_id']) && $_GET['user_id'] == $_SESSION['user_id'];
    }
}