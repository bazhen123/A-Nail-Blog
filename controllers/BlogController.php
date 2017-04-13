<?php

class BlogController
{
  public function actionIndex()
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    // 'Список новостей';
    $postList = array();
    $postList = Blog::getBlogList(10);

    /*echo '<pre>';
    print_r($newsList);
    echo '</pre>';*/

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
      require_once(ROOT . '/views/blog/article.php');
    }
    return true;
  }

}