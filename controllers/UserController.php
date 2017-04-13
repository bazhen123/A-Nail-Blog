<?php

class UserController
{
  public function actionRegister()
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $name     = '';
    $email    = '';
    $password = '';
    $role     = '';
    $result   = false;

    if (isset($_POST['submit'])) {
      $name       = $_POST['name'];
      $email      = $_POST['email'];
      $password   = $_POST['password'];
      $repassword = $_POST['repassword'];
      $role       = 'user';
      $errors     = false;

      if (!User::checkName($name))
      {
        $errors[] = 'Имя не должно быть короче 2-х символов';
      }

      if (!User::checkEmail($email))
      {
        $errors[] = 'Неправильный email';
      }

      if (!User::checkPassword($password))
      {
        $errors[] = 'Пароль не должен быть короче 6-ти символов';
      }

      if (!User::checkRepassword($password, $repassword))
      {
        $errors[] = 'Пароли не совпадают';
      }

      if (User::checkEmailExists($email))
      {
        $errors[] = 'Такой email уже используется';
      }

      if ($errors == false)
      {
        $result = User::register($name, $email, $password, $role);
        header("Location: /cabinet/");
      }
    }

    require_once (ROOT . '/views/user/register.php');

    return true;
  }

  public function actionLogin()
  {
    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $email    = '';
    $password = '';

    if (isset($_POST['submit']))
    {
      $email    = $_POST['email'];
      $password = $_POST['password'];

      $errors = false;

      // Проверяем существует ли пользователь
      $userId = User::checkUserData($email, $password);

      if ($userId == false)
      {
        // Если данные не правильные - показываем ошибку
        $errors[] = 'Не правильные данные для входа на сайт';
      } else
      {
        // Если данные правильные, запоминаем пользователя в сесии
        User::auth($userId);

        // Перенаправляем пользователя в закрытую часть - кабинет
        header("Location: /cabinet/");
      }
    }
    require_once (ROOT . '/views/user/login.php');

    return true;
  }

  /*
   * Удаляем данные о пользователе из сессии
   */
  public function actionLogout()
  {
    unset($_SESSION['user']);
    header("Location: /");
  }

  /*
   * Запись комментария в БД
   */
  public function actionComments()
  {
    $text       = '';
    $article_id = '';
    $parent_id  = '';
    $result     = false;

    $redicet = $_SERVER['HTTP_REFERER'];
    $redicet = $redicet . '#comment_form';

    if (isset($_POST['submit'])) {
      $text = $_POST['comment'];
      $article_id = $_POST['article_id'];
      $parent_id = $_POST['parent_id'];
      $errors = false;

      if (!User::checkMessage($text))
      {
        @header ("Location: $redicet");
        $errors[] = 'Введите текст комментария';
      }

      if ($errors == false)
      {
        $result = User::comment($text, $article_id, $parent_id);
      }
    }

    // Перенаправляем пользователя обратно
    @header ("Location: $redicet");

    return true;


  }


}