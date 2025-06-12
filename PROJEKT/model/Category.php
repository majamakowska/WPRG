<?php
class Category
{
    private $id;
    private $name;
    public function __construct($db, $id)
    {
        $this->id = $id;
        $result = $db->runQuery("SELECT * FROM categories WHERE id = ?", [$this->id]);
        $this->name = $result->fetch_assoc()['name'];
    }
    public static function getCategoryName($db, $id) {
        return $db->runQuery("SELECT name from categories WHERE id = ?", [$id])->fetch_assoc()['name'];
    }
    public static function echoCategoryDatalist($db) {
        $result = $db->runQuery("SELECT * FROM categories");
        echo "<datalist id = 'category_names'>";
        foreach ($result as $category) {
            echo "<option value = '" . $category['name'] . "'>" . $category['name'] . "</option>";
        }
        echo "</datalist>";
    }
    public static function echoCategorySelect($db, $selectedCategory = null) {
        $result = $db->runQuery("SELECT * FROM categories ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            $selected = ($selectedCategory != null & $selectedCategory == $row['id']) ? ' selected' : '';
            echo "<option value='" . $row['id'] . "'" . $selected . ">" . htmlspecialchars($row['name']) . "</option>";
        }
    }
    public static function getPostsFromCategory($db, $category_id) {
        $result = $db->runQuery("SELECT * FROM posts WHERE category_id = ?", [$category_id]);
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = new Post($db, $row);
        }
        return $posts;
    }
    public static function delete($db, $category_id) {
        $db->runQuery("DELETE FROM categories WHERE id = ?", [$category_id]);
        Database::onDeleteCascade_posts($db);
    }
}