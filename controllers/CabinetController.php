<?php

class CabinetController
{
  public function actionIndex()
  {
    $title = 'A Nail Blog - Акаунт';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $userId = User::checkLogger();

    // Получаем информацию о пользователе из БД
    $user = User::getUserById($userId);

    require_once (ROOT . '/views/cabinet/index.php');

    return true;
  }

  public function actionEdit()
  {
    $title = 'A Nail Blog - Акаунт';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    // Получаем идентификатор пользователя из сессии
    $userId = User::checkLogger();

    // Получаем информацию о пользователе
    $user     = User::getUserById($userId);
    $name     = $user['name'];
    $password = $user['password'];

    $result = false;

    if (isset($_POST['submit']))
    {
      $name       = $_POST['name'];
      $password   = $_POST['password'];
      $errors     = false;

      if (!User::checkName($name))
      {
        $errors[] = 'Имя не должно быть короче 2-х символов';
      }

      if (!User::checkPassword($password))
      {
        $errors[] = 'Пароль не должен быть короче 6-ти символов';
      }

      if ($errors == false)
      {
        $result = User::edit($userId, $name, $password);
      }

    }

    require_once (ROOT . '/views/cabinet/edit.php');

    return true;
  }

}