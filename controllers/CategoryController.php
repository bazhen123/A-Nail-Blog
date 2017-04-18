<?php

class CategoryController
{
  public function actionIndex($category_id, $page)
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $total  = Category::getCountArticlesInCategory($category_id);

    $articlesInCategory = Category::getCategoryArticles($category_id);  // Получае количество статей в категории.

    foreach ($categories as $category)  // Получаем Title для страници.
    {
      if ($category_id == $category['id'])
      {
        $title = 'A Nail Blog - ' . $category['name'];
        break;
      }
    }
    // Создаём объект Pagination - постраничная навигация
    $pagination = new Pagination($total, $page, Blog::SHOW_BY_DEFAULT, 'page-');

    require_once (ROOT . '/views/blog/category.php');

    return true;
  }
}