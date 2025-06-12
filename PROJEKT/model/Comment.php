<?php
class Comment
{
    private $id;
    private $post_id;
    private $user_id;
    private $author;
    private $datetime;
    private $content;
    public function __construct($db, array $comment) {
        $this->id = $comment['id'];
        $this->post_id = $comment['post_id'];
        $this->user_id = $comment['user_id'];
        $this->author = $comment['author'];
        $this->datetime = (new DateTime($comment['datetime']))->format('Y-m-d H:i');
        $this->content = ($comment['content']);
    }
    public function getId() {
        return $this->id;
    }
    public function getPostId() {
        return $this->post_id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getAuthor() {
        return $this->author;
    }
    public function getDatetime() {
        return $this->datetime;
    }
    public function getContent() {
        return $this->content;
    }
    public static function getComments($db, $post_id) {
        $result=$db->runQuery("SELECT * FROM comments WHERE post_id = ? ORDER BY datetime DESC", [$post_id]);
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = new Comment($db, $row);
        }
        return $comments;
    }
    public static function delete($db, $id) {
        $db->runQuery("DELETE FROM comments WHERE id = ?", [$id]);
    }
}