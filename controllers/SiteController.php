<?php

class SiteController
{

  public function actionIndex()
  {

    $title = 'A Nail Blog';

    require_once(ROOT . '/views/site/index.php');

    return true;
  }

  public function actionContact()
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    require_once(ROOT . '/views/site/contact.php');

    return true;
  }

  public function actionAbout()
  {
    $title = 'A Nail Blog - Контакты';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    require_once(ROOT . '/views/site/about.php');

    return true;
  }

  public function actionError404()
  {
    $title = 'A Nail Blog - Страница не найдена';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    require_once (ROOT . '/views/site/404.php');

    return true;
  }

}
