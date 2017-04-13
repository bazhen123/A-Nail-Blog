<?php

class CategoryController
{
  public function actionIndex($category_id)
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $articlesInCategory = Category::getCategoryArticles($category_id);

    require_once (ROOT . '/views/blog/category.php');

    return true;
  }
}