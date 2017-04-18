<?php

class Blog
{
  const SHOW_BY_DEFAULT = 5;
  /**
   * Returns single blog item with specified id
   * @param integer $id
   */
  public static function getBlogItemById($id)
  {
    $id = intval($id);

    if ($id) {

      $db = Db::getConnection();

      $result = $db->query('SELECT * FROM blog WHERE id=' . $id);
      $result->setFetchMode(PDO::FETCH_ASSOC);

      $blogItem = $result->fetch();
      $count = User::getTotalComments($id);

      $blogItem['count'] = $count;

      return $blogItem;
    }
  }

  /**
   * Returns an array of blog items
   */
  public static function getBlogList($page = 1)
  {
    $page = intval($page);
    $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

    // Запрос к БД
    $db = Db::getConnection();

    $blogList = array();

    $result = $db->query('SELECT * FROM blog ORDER BY datetime DESC LIMIT ' . self::SHOW_BY_DEFAULT . ' OFFSET ' . $offset);

    $i = 0;
    while($row = $result->fetch()) {
      $blogList[$i]['id'] = $row['id'];
      $blogList[$i]['title'] = $row['title'];
      $blogList[$i]['datetime'] = $row['datetime'];
      $blogList[$i]['author_name'] = $row['author_name'];
      $blogList[$i]['image'] = $row['image'];
      $blogList[$i]['text'] = $row['text'];
      $blogList[$i]['category'] = $row['category'];
      $blogList[$i]['category_id'] = $row['category_id'];
      $blogList[$i]['views'] = $row['views'];
      $blogList[$i]['tags'] = $row['tags'];
      $blogList[$i]['count'] = User::getTotalComments($row['id']);
      $i++;
    }
    return $blogList;
  }

  public static function getTopList($limit)
  {
    // Запрос к БД
    $db = Db::getConnection();

    $topList = array();

    $result = $db->query('SELECT id, title, text FROM blog ORDER BY views DESC LIMIT ' . $limit);

    $i = 0;
    while($row = $result->fetch())
    {
      $topList[$i]['id']    = $row['id'];
      $topList[$i]['title'] = $row['title'];
      $topList[$i]['text']  = $row['text'];
      $i++;
    }
    return $topList;
  }

  public static function getDateTimeExplode($dateTime)
  {

    // 2017-01-30 19:53:56
    $dtElements     = array();
    $dateElements   = array();
    $timeElements   = array();

    // Разбиение строки в 2 части - date, time
    $dtElements = explode(' ', $dateTime);
    // Разбиение даты
    $dateElements = explode('-', $dtElements[0]);
    // Разбиение времени
    $timeElements =  explode(':',$dtElements[1]);

    $dateTime = array();
    $dateTime['year']     = $dateElements[0];
    $dateTime['month']    = $dateElements[1];
    $dateTime['day']      = $dateElements[2];
    $dateTime['hours']    = $timeElements[0];
    $dateTime['minutes']  = $timeElements[1];
    $dateTime['seconds']  = $timeElements[2];

    return $dateTime;
  }

  public static function getTotalCountArticles()
  {
    $db = Db::getConnection();

    $result = $db->query('SELECT count(id) AS count FROM blog ');
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();

    return $row['count'];
  }
}