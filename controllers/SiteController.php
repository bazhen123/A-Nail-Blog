<?php

class SiteController
{

  public function actionIndex()
  {

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
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    require_once(ROOT . '/views/site/about.php');

    return true;
  }

}
