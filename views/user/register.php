<?php require_once (ROOT . "/views/layouts/header.php");?>

  <!-- Page Header -->
  <!-- Set your background image for this header on the line below. -->
  <header class="intro-header" style="background-image: url('/template/images/blog-bg.jpg')">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
          <div class="site-heading">
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">

      <!-- Main -->
      <main>
        <div class="col-lg-9  col-md-8 col-sm-12">
          <div class="page-container">

            <!-- breadcrumb -->
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Регистрация</li>
              </ol>
            </div>

            <?php if($success):?>
              <div class="row">
                <p class="help-block text-success"><?=$success;?></p>
              </div>
            <? else:?>

            <div class="row">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form method="post" action="" id="registerForm">

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Имя или Ник</label>
                      <input type="text" name="name" class="form-control" placeholder="Имя или Ник"
                             value="<?=$name;?>" required data-toggle="help-block" data-target="#name">
                      <p id="name" class="help-block text-danger">
                        <?php if (isset($errors['name'])) echo $errors['name'];?>
                      </p>
                    </div>
                  </div>
                  
                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Email адрес</label>
                      <input type="email" name="email" class="form-control" placeholder="Email"
                             value="<?=$email;?>" required data-toggle="help-block" data-target="#email">
                      <p id="email" class="help-block text-danger">
                        <?php if (isset($errors['email'])) echo $errors['email'];?>
                        <?php if (isset($errors['exists_email'])) echo $errors['exists_email'];?>
                      </p>
                    </div>
                  </div>

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Пароль</label>
                      <input type="password" name="password" class="form-control" placeholder="Пароль"
                             required autocomplete="off" data-toggle="help-block" data-target="#password">
                      <p id="password" class="help-block text-danger">
                        <?php if (isset($errors['password'])) echo $errors['password'];?>
                      </p>
                    </div>
                  </div>

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Введите код с картинки</label>
                      <input type="text" name="captcha" class="form-control" placeholder="Введите код с картинки"
                             required autocomplete="off" data-toggle="help-block" data-target="#captcha">
                      <p id="captcha" class="help-block text-danger">
                        <?php if (isset($errors['captcha'])) echo $errors['captcha'];?>
                      </p>
                    </div>
                  </div>

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <img src="<?php echo '../../components/Captcha.php'; ?>" id='capcha-image'>
                      <!-- Сама капча -->
                      <a class="btn btn-link" href="javascript:void(0);"
                         onclick="document.getElementById('capcha-image').src='../../components/Captcha.php?id='+Math.round(Math.random()*9999)">Обновить</a>
                      <!-- Ссылка на обновление капчи. Запрашиваем у captcha.php случайное изображение.  -->
                    </div>
                  </div>
                  <br>

                  <div class="row">
                    <div class="form-group col-xs-12">
                      <input type="submit" class="btn btn-default" name="submit" value="Зарегистрироваться">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <? endif;?>

          </div>
        </div>
      </main>

      <!-- Sidebar -->
      <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

    </div>
  </div>


  <!-- Footer -->
<?php require_once (ROOT . "/views/layouts/footer.php");?>