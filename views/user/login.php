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
                <li class="active">Вход</li>
              </ol>
            </div>

            <div class="col-sm-8 col-sm-offset-2 padding-right">
              <?php if (isset($successActive)): ?>
                <p class="help-bloch text-success"><?=$successActive;?></p>
              <?php endif ;?>
              <?php if (isset($errorActive)): ?>
                <p class="help-bloch text-danger"><?=$errorActive;?></p>
              <?php endif ;?>
            </div>

            <div class="row">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form method="post" action="" id="loginForm">
                  
                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Email адрес</label>
                      <input type="email" name="email" class="form-control" placeholder="Email" value="<?=$email; ?>" required>
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Пароль</label>
                      <input type="password" name="password" class="form-control" placeholder="Пароль" required >
                      <p class="help-block text-danger">
                        <?php if (isset($errors) && is_array($errors)): ?>
                          <?php foreach ($errors as $error): ?>
                            <?=$error;?>
                          <?php endforeach; ?>
                        <? endif ;?>
                      </p>
                    </div>
                  </div>
                  <br>

                  <div class="row">
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="remember"> Запомнить меня
                        </label>
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-default" name="submit" value="Войти">
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="row">
                  <a class="btn btn-link" href="/user/register/">Зарегистрироваться</a>
                  <a class="btn btn-link" href="/user/restore/">Восстановить пароль</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </main>

      <!-- Sidebar -->
      <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

    </div>
  </div>


  <!-- Footer -->
<?php require_once (ROOT . "/views/layouts/footer.php");?>