<?php

class BlogController
{
  public function actionIndex($page)
  {
    $title = 'A Nail Blog - Блог';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);
    $total = Blog::getTotalCountArticles();

    // 'Список новостей';
    $postList = array();
    $postList = Blog::getBlogList($page);

    /*echo '<pre>';
    print_r($newsList);
    echo '</pre>';*/

    // Создаём объект Pagination - постраничная навигация
    $pagination = new Pagination($total, $page, Blog::SHOW_BY_DEFAULT, 'page-');

    require_once (ROOT . '/views/blog/index.php');

    return true;
  }

  public function actionArticle($id)
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    if ($id)
    {
      $comments = User::getComments($id);
      $blogItem = Blog::getBlogItemById($id);

     /* echo '<pre>';
    print_r($blogItem);
    echo '</pre>';*/
      $title = 'A Nail Blog - ' . $blogItem['title'];

      require_once(ROOT . '/views/blog/article.php');
    }
    return true;
  }

}