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

    $articlesInCategory = Category::getCategoryArticles($category_id);  // Получае количество статей в категории.

    foreach ($categories as $category)  // Получаем Title для страници.
    {
      if ($category_id == $category['id'])
      {
        $title = 'A Nail Blog - ' . $category['name'];
        break;
      }
    }

    require_once (ROOT . '/views/blog/category.php');

    return true;
  }
}