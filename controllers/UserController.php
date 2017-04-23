<?php

class UserController
{
  /*
   * Регистрация пользователя
   */
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
    $success  = false;

    // Обрабатываем POST запрос
    if (isset($_POST['submit']))
    {
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

      // Если нет ошибок записываем пользователя в БД
      // и отправляем письмо для подтверждения E-mail адреса
      if ($errors == false)
      {
        // Шифруем пароль
        $password = User::genPass($password, $email);
        // Записываем в БД
        $result   = User::register($name, $email, $password, $role);
        // Если запись прошла успешно, то отправляем пользователю письмо
        if ($result)
        {
          // тема письма
          $subject = 'Подтверждение регистрацию на сайте A Nail Blog';
          $code = substr(base64_encode($email), 0, -1);
          // ссылка на подтверждение
          $link = 'ссылка для активации: http://bazhenbazhenov.tk/user/activate/' . substr($code, -5) . substr($code, 0, -5);
          // текст письма
          $message = $link . ' Пароль для входа: ' . $_POST['password'];
          $header = 'From: A Nail Blog: bazhen@bazhenbazhenov.tk';

          $mail = mail($email, $subject, $message, $header);

          if ($mail)
          {
            $_SESSION['regEmail'] = $email;
            $success = 'Вы успешно зарегистрировались, на указанный Вами E-mail отправлено сообщение. Для подтверждения регистрации перейдите по ссылке в сообщении.';
          }
          else
          {
            $errors['mail'] = 'Ошибка отправки сообщения, повторите попытку ещё раз';
          }
          unset($_SESSION["img_code"]);
        }
      }
    }

    require_once (ROOT . '/views/user/register.php');

    return true;
  }

  /*
   * Форма входа на сайт
   */
  public function actionLogin()
  {
    $title = 'A Nail Blog - Вход';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    if (isset($_SESSION['active_email']))
    {
      $successActive = $_SESSION['active_email'];
    }

    if (isset($_SESSION['error_active_email']))
    {
      $errorActive = $_SESSION['error_active_email'];
    }

    $email    = '';
    $password = '';

    // Обрабатываем POST запрос
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

        if (isset($_POST['remember']))
        {
          setcookie('remember', $_SESSION['user'], strtotime('+30 days'), '/');
        }

        // Перенаправляем пользователя в закрытую часть - кабинет
        header("Location: /cabinet/");
      }
    }
    require_once (ROOT . '/views/user/login.php');

    unset($_SESSION['active_email']);
    unset($_SESSION['error_active_email']);

    return true;
  }

  /*
   * Удаляем данные о пользователе из сессии и cookie
   */
  public function actionLogout()
  {
    unset($_SESSION['user']);
    setcookie('remember', '', strtotime('-30 days'), '/');
    unset($_COOKIE['remember']);
    header("Location: /");
  }

  /*
   * Восстановление пароля
   */
  public function actionRestore()
  {
    $title = 'A Nail Blog - Восстановление пароля';

    $categories     = array();
    $topArticles    = array();
    $latestComments = array();
    $categories     = Category::getCategoriesList();
    $topArticles    = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $email    = '';
    $captcha  = '';
    $result   = false;
    $success  = false;

    if (isset($_POST['submit']))
    {
      $email = User::formChars($_POST['email']);
      $captcha = User::formChars($_POST['captcha']);
      $errors = false;

      if (!User::checkEmailExists($email))
      {
        $errors['exists_email'] = 'Пользовательс таким E-mail не зарегистрирован';
      }
      if (!User::checkEmail($email))
      {
        $errors['email'] = 'Неправильный email';
      }

      if (!User::checkCaptcha($captcha))
      {
        $errors['captcha'] = 'Не правильный код';
      }

      if ($errors == false)
      {
        // тема письма
        $subject = 'Восстановление пароля A Nail Blog';
        $code = substr(base64_encode($email), 0, -1);
        // ссылка на подтверждение
        $link = 'ссылка для восстановления: http://bazhenbazhenov.tk/user/restorepass/' . substr($code, -5) . substr($code, 0, -5);
        // текст письма
        $message = $link;
        $header = 'From: A Nail Blog: bazhen@bazhenbazhenov.tk';

        $mail = mail($email, $subject, $message, $header);

        if ($mail)
        {
          $_SESSION['restoreEmail'] = $email;
          $success = 'На указанный Вами E-mail отправлено сообщение. Для продолжения восстановления пароля перейдите по ссылке в сообщении.';
        }
        else
        {
          $errors['mail'] = 'Ошибка отправки сообщения, повторите попытку ещё раз';
        }
        unset($_SESSION["img_code"]);
      }
    }

    require_once (ROOT . '/views/user/restore.php');

    return true;
  }

  /*
   * Страница изменения пароля
   */
  public function actionRestorepass($code)
  {
    $title = 'A Nail Blog - Восстановление пароля';

    $categories = array();
    $topArticles = array();
    $latestComments = array();
    $categories = Category::getCategoriesList();
    $topArticles = Blog::getTopList(3);
    $latestComments = User::getLatestComments(3);

    $errors = false;

    if (User::isGuest())
    {
      // раскодируем E-mail
      $email = base64_decode(substr($code, 5) . substr($code, 0, 5));
      if (strpos($email, '@'))
      {
        // Получаем информацию о пользователе из БД
        $user = User::getUserByEmail($email);
        if ($user)
        {
          // Обрабатываем POST запрос
          if (isset($_POST['submit']))
          {
            $password = User::formChars($_POST['password']);
            $captcha = User::formChars($_POST['captcha']);

            $errors = false;

            if (!User::checkPassword($password))
            {
              $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }

            if (!User::checkCaptcha($captcha))
            {
              $errors['captcha'] = 'Не правильный код';
            }

            // Если нет ошибок записываем новый пароль в БД
            // и отправляем письмо о изменении пароля
            if ($errors == false)
            {
              // Шифруем пароль
              $password = User::genPass($password, $email);

              $result = User::updatePassword($password, $email);
              if ($result)
              {
                // тема письма
                $subject = 'Изменение пароля на сайте A Nail Blog';
                // текст письма
                $message = 'Новый пароль для входа: ' . $_POST['password'];
                // Заголовок
                $header = 'From: A Nail Blog: bazhen@bazhenbazhenov.tk';

                // Отправляем сообщение пользователю
                $mail = mail($email, $subject, $message, $header);

                // Выводим сообщение об отправке письма
                if ($mail)
                {
                  $success = 'Пароль был успешно изменён, на указанный Вами E-mail отправлено сообщение с паролем.';
                }
                else
                {
                  $errors['mail'] = 'Ошибка отправки сообщения, повторите попытку ещё раз.';
                }
                unset($_SESSION["img_code"]);
              }
            }
          }
        }
        else
        {
          $errors['info'] = 'Ошибка восстановления пароля: Не удалось получить информацию о пользователе.';
        }
      }
      else
      {
        $errors['link'] = 'Ошибка восстановления пароля: не корректная ссылка на восстановление.';
      }

    }
    else
    {
      // Перенаправляем пользователя в кабинет
      header("Location: /cabinet/");
    }

    require_once (ROOT . '/views/user/restorepass.php');

    return true;
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

    // Получае адрес для перенаправления
    $redicet = $_SERVER['HTTP_REFERER'];
    $redicet = $redicet . '#comment_form';

    // Обрабатываем POST запрос
    if (isset($_POST['submit']))
    {
      $text       = User::formChars($_POST['comment']);
      $article_id = $_POST['article_id'];
      $parent_id  = $_POST['parent_id'];
      $errors     = false;

      if (!User::checkMessage($text))
      {
        @header ("Location: $redicet");
        $errors[] = 'Введите текст комментария';
      }

      // Если нет ошибок добавляем комментарий в БД
      if ($errors == false)
      {
        $result = User::comment($text, $article_id, $parent_id);
      }
    }

    // Перенаправляем пользователя обратно
    @header ("Location: $redicet");

    return true;

  }

  /*
   * Подтверждение E-mail адреса
   */
  public function actionActivate($code)
  {
    if (User::isGuest())
    {
      // раскодируем E-mail
      $email = base64_decode(substr($code, 5) . substr($code, 0, 5));

      if (strpos($email, '@'))
      {
        // Проверяем статус активации емаил
        $active = User::activeEmailStatus($email);
        if (!$active)
        {
          // Обновляем статус в БД
          $result = User::updateActive($email);
          if ($result)
          {
            $success = ' E-mail ' . $email . ' успешно подтверждён.';
            $_SESSION['active_email'] = $success;
            header("Location: /user/login");
            return true;
          }
          else
          {
            $error = 'Ошибка активации';
            $_SESSION['error_active_email'] = $error;
            header("Location: /user/login");
            return true;
          }
        }
        else
        {
          $success = ' E-mail ' . $email . ' уже был подтверждён ранее.';
          $_SESSION['active_email'] = $success;
          header("Location: /user/login");
          return true;
        }
      }
      else
      {
        $error = 'E-mail не подтверждён.';
        $_SESSION['error_active_email'] = $error;
        header("Location: /user/login");
      }
    }

    return true;
  }

}