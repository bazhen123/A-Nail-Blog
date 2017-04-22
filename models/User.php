<?php

class User
{

  public static function register($name, $email, $password, $role)
{
$db = Db::getConnection();
$sql = 'INSERT INTO user (name, email, password, role, active) VALUES (:name, :email, :password, :role, :active)';
$active = 0;

$result = $db->prepare($sql);
$result->bindParam(':name', $name, PDO::PARAM_STR);
$result->bindParam(':email', $email, PDO::PARAM_STR);
$result->bindParam(':password', $password, PDO::PARAM_STR);
$result->bindParam(':role', $role, PDO::PARAM_STR);
$result->bindParam(':active', $active, PDO::PARAM_STR);

return $result->execute();

}

  /*
   * Проверяем имя: не менее, чем 2 символа
   */
  public static function checkName($name)
  {
    if (strlen($name) >= 2)
    {
      return true;
    }
    return false;
  }

  /*
   * Проверяе пароль: не менее, чем 6 символов
   */
  public static function checkPassword($password)
  {
    if (strlen($password) >= 6)
    {
      return true;
    }
    return false;
  }

  /*
   * Проверяем email
   */
  public static function checkEmail($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return true;
    }
    return false;
  }

  /*
   * Проверяем используется такой email или нет
   */
  public static function checkEmailExists($email)
  {
    $db = Db::getConnection();
    $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

    $result = $db->prepare($sql);
    $result->bindParam(':email', $email, PDO::PARAM_STR);
    $result->execute();

    if ($result->fetchColumn())
    {
      return true;
    }
    return false;
  }

  /*
   * Проверяем правильность ввода каптчи
   */
  public static function checkCaptcha($captcha)
  {
    if (strtoupper($captcha) == strtoupper($_SESSION["img_code"]))
    {
      return true;
    }
    return false;
  }

  public static function formChars($p1)
  {
    return nl2br(strip_tags(trim($p1)));
  }

  /*
   * Шифрование пароля
   */
  public static function genPass($pass, $login)
  {
    return md5('ANAILBLOG' . md5('321' . $pass . '123') . md5('891' . $login . '654'));
  }

  /*
   * Обновляем статус регистрации пользователя
   */
  public static function updateActive($email)
  {
    $db = Db::getConnection();
    $sql = 'UPDATE user SET active=:active WHERE email = :email';
    $active = 1;

    $result = $db->prepare($sql);
    $result->bindParam(':email', $email, PDO::PARAM_INT);
    $result->bindParam(':active', $active, PDO::PARAM_INT);
    $result->execute();

    return true;
  }
  /*
   * Получаем статус активации E-mail ползователя
   */
  public static function activeEmailStatus($email)
  {
    $db = Db::getConnection();
    $sql = 'SELECT active FROM user WHERE email = :email';

    $result = $db->prepare($sql);
    $result->bindParam(':email', $email, PDO::PARAM_INT);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);

    $active = $result->fetch();
    if ($active['active'] == '1')
    {
      return true;
    }
    return false;
  }

  /*
   * Проверяем существует ли пользователь с заданными $email и $password
   * @param string $email
   * @param string $password
   * @return mixed : integer user id or false
   */
  public static function checkUserData($email, $password)
  {
    $db = Db::getConnection();
    $sql = 'SELECT * FROM user WHERE email = :email AND password = :password AND active=:active';
    $active = 1;

    $result = $db->prepare($sql);
    $result->bindParam(':email', $email, PDO::PARAM_INT);
    $result->bindParam(':password', $password, PDO::PARAM_INT);
    $result->bindParam(':active', $active, PDO::PARAM_INT);
    $result->execute();

    $user = $result->fetch();

    if ($user)
    {
      return $user['id'];
    }
    return false;
  }

  /*
   * Запоминаем пользователя
   * @param string $email
   * @param string $password
   */
  public static function auth($userId)
  {
    $_SESSION['user'] = $userId;
  }

  public static function checkLogger()
  {
    // Если сессия есть, вернём идентификатор пользователя
    if (isset($_SESSION['user']))
    {
      return $_SESSION['user'];
    }

    header("Location: /user/login");
  }

  public static function isGuest()
  {
    if (isset($_SESSION['user']))
    {
      return false;
    }
    return true;
  }

  /**
   * Returns product item by id
   * @param integer $id
   */
  public static function getUserById($id)
  {
    if ($id) {
      $db = Db::getConnection();
      $sql = 'SELECT * FROM user WHERE id = :id';

      $result =$db->prepare($sql);
      $result->bindParam(':id', $id, PDO::PARAM_INT);

      // Указываем, что хотим получить данные в виде массива
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $result->execute();

      return $result->fetch();
    }
    return false;
  }

  /*
   * Редактирование данных пользователя
   * @param integer $id
   * @param string $name
   * @param string $password
   */
  public static function edit($id, $name, $password)
  {
    $db = Db::getConnection();
    $sql = 'UPDATE user SET name = :name, password = :password WHERE id = :id';

    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->bindParam(':password', $password, PDO::PARAM_STR);

    return $result->execute();
  }


  public static function getComments($article_id)
  {
    // Запрос к БД
    $db = Db::getConnection();

    $comments = array();

    $result = $db->query('SELECT * FROM comments WHERE parent_id=0 AND article_id="' . $article_id . '"ORDER BY date DESC');

    $i = 0;
    while ($row = $result->fetch())
    {
      $comments[$i]['id']             = $row['id'];
      $comments[$i]['author']         = $row['author'];
      $comments[$i]['text']           = $row['text'];
      $comments[$i]['date']           = $row['date'];
      $comments[$i]['parent_id']      = $row['parent_id'];
      $comments[$i]['article_id']     = $article_id;
      $i++;
    }

    return $comments;
  }

  public static function getChildComments($comment_id, $article_id)
  {
    // Запрос к БД
    $db = Db::getConnection();

    $commentsChild = array();

    $result = $db->query('SELECT * FROM comments WHERE parent_id=' . $comment_id . ' AND article_id="' . $article_id . '"ORDER BY date DESC');

    $i = 0;
    while ($row = $result->fetch())
    {
      $commentsChild[$i]['id']        = $row['id'];
      $commentsChild[$i]['author']    = $row['author'];
      $commentsChild[$i]['text']      = $row['text'];
      $commentsChild[$i]['date']      = $row['date'];
      $commentsChild[$i]['parent_id'] = $row['parent_id'];
      $i++;
    }
    return $commentsChild;
  }
  /*
   * Получаем список последних комметариев
   */
  public static function getLatestComments($limit)
  {
    // Запрос к БД
    $db = Db::getConnection();

    $latestComments = array();

    $result = $db->query('SELECT * FROM comments ORDER BY date DESC LIMIT ' . $limit);

    $i = 0;
    while ($row = $result->fetch())
    {
      $latestComments[$i]['id']         = $row['id'];
      $latestComments[$i]['author']     = $row['author'];
      $latestComments[$i]['text']       = $row['text'];
      $latestComments[$i]['date']       = $row['date'];
      $latestComments[$i]['parent_id']  = $row['parent_id'];
      $latestComments[$i]['article_id'] = $row['article_id'];
      $i++;
    }
    return $latestComments;
  }
  public static function getTotalComments($article_id)
  {
    // Запрос к БД
    $db = Db::getConnection();

    $result = $db->query('SELECT id FROM comments WHERE article_id=' .$article_id);

    $count = count($result->fetchAll());

    return $count;
  }
  /*
   *
   */
  public static function checkMessage($text)
  {
    if (strlen($text) > 0)
    {
      return true;
    }
    return false;
  }

  public static function comment($text, $article_id, $parent_id)
  {
    $db = Db::getConnection();
    $sql = 'INSERT INTO comments (author,text, article_id, parent_id, date) VALUES (:author, :text, :article_id, :parent_id, NOW())';

    // Получаем идентификатор пользователя из сессии
    $userId = User::checkLogger();

    // Получаем информацию о пользователе
    $user   = User::getUserById($userId);
    $author = $user['name'];

    $result = $db->prepare($sql);
    $result->bindParam(':author', $author, PDO::PARAM_STR);
    $result->bindParam(':text', $text, PDO::PARAM_STR);
    $result->bindParam(':article_id', $article_id, PDO::PARAM_STR);
    $result->bindParam(':parent_id', $parent_id, PDO::PARAM_STR);

    return $result->execute();

  }

}