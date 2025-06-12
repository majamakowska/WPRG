<?php
class Post
{
    private $id;
    private $user_id;
    private $datetime;
    private $category_id;
    private $subject;
    private $content;

    public function __construct($db, array $row)
    {
        $this->id = (int)$row['id'];
        $this->user_id = htmlspecialchars($row['user_id']);
        $this->datetime = (new DateTime($row['datetime']))->format('Y-m-d H:i');
        $this->category_id = htmlspecialchars($row['category_id']);
        $this->subject = htmlspecialchars($row['subject']);
        $this->content = htmlspecialchars($row['content']);
    }
    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getDatetime() {
        return $this->datetime;
    }
    public function getCategoryId() {
        return $this->category_id;
    }
    public function getSubject() {
        return $this->subject;
    }
    public function getContent() {
        return $this->content;
    }
    public static function delete($db, $id) {
        $db->runQuery("DELETE FROM posts WHERE id = ?", [$id]);
        Database::onDeleteCascade_comments($db);
    }
} ?>