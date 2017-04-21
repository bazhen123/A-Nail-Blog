<?php

class UserController
{
  public function actionRegister()
  {
    $title = 'A Nail Blog - Регистрация';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $name     = '';
    $email    = '';
    $password = '';
    $captcha  = '';
    $role     = '';
    $result   = false;

    if (isset($_POST['submit'])) {
      $name       = User::formChars($_POST['name']);
      $email      = User::formChars($_POST['email']);
      $password   = User::formChars($_POST['password']);
      $captcha    = User::formChars($_POST['captcha']);
      $role       = 'user';
      $errors     = false;

      if (!User::checkName($name))
      {
        $errors['name'] = 'Имя не должно быть короче 2-х символов';
      }

      if (!User::checkEmail($email))
      {
        $errors['email'] = 'Неправильный email';
      }

      if (!User::checkPassword($password))
      {
        $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
      }

      if (User::checkEmailExists($email))
      {
        $errors['exists_email'] = 'Такой email уже используется';
      }

      if (!User::checkCaptcha($captcha))
      {
        $errors['captcha'] = 'Не правильный код';
      }

      if ($errors == false)
      {
        $password = User::genPass($password, $email);
        $result   = User::register($name, $email, $password, $role);
        unset( $_SESSION["img_code"] );
        header("Location: /cabinet/");
      }
    }

    require_once (ROOT . '/views/user/register.php');

    return true;
  }

  public function actionLogin()
  {
    $title = 'A Nail Blog - Вход';

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
      $password = User::genPass($password, $email);

      $errors = false;

      // Проверяем существует ли пользователь
      $userId = User::checkUserData($email, $password);

      if ($userId == false)
      {
        // Если данные не правильные - показываем ошибку
        $errors[] = 'Не правильные данные для входа на сайт';
      }
      else
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
      $text       = User::formChars($_POST['comment']);
      $article_id = $_POST['article_id'];
      $parent_id  = $_POST['parent_id'];
      $errors     = false;

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