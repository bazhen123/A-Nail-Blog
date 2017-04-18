<?php

class Category
{
  /**
   * Returns an array of categories
   */
  public static function getCategoriesList()
  {

    $db = Db::getConnection();

    $categoryList = array();

    $result = $db->query('SELECT id, name FROM category ORDER BY sort_order ASC');

    $i = 0;
    while ($row = $result->fetch())
    {
      $categoryList[$i]['id']         = $row['id'];
      $categoryList[$i]['name']       = $row['name'];
      $categoryList[$i]['count_art']  = self::getCountArticlesInCategory($row['id']);
      $i++;
    }
    return $categoryList;
  }

  public static function getCategoryArticles($category_id, $page = 1)
  {
    $page = intval($page);
    $offset = ($page - 1) * Blog::SHOW_BY_DEFAULT;

    $db = Db::getConnection();

    $categoryArticle = array();

    $result = $db->query('SELECT * FROM blog WHERE category_id=' . ($category_id) .
      ' ORDER BY datetime DESC LIMIT ' . Blog::SHOW_BY_DEFAULT . ' OFFSET ' . $offset);

    $i = 0;
    while($row = $result->fetch()) {
      $categoryArticle[$i]['id']          = $row['id'];
      $categoryArticle[$i]['title']       = $row['title'];
      $categoryArticle[$i]['datetime']    = $row['datetime'];
      $categoryArticle[$i]['author_name'] = $row['author_name'];
      $categoryArticle[$i]['image']       = $row['image'];
      $categoryArticle[$i]['text']        = $row['text'];
      $categoryArticle[$i]['category']    = $row['category'];
      $categoryArticle[$i]['category_id'] = $row['category_id'];
      $categoryArticle[$i]['views']       = $row['views'];
      $categoryArticle[$i]['tags']        = $row['tags'];
      $categoryArticle[$i]['count']       = User::getTotalComments($row['id']);
      $i++;
    }

    return $categoryArticle;
  }

  public static function getCountArticlesInCategory($category_id)
  {
    $db = Db::getConnection();

    $result = $db->query('SELECT id FROM blog WHERE category_id=' . $category_id);

    $count = count($result->fetchAll());

    return $count;
  }

}