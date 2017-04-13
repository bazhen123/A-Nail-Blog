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

            <div class="col-sm-8 col-sm-offset-2 padding-right">
              <?php if (isset($errors) && is_array($errors)): ?>
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors as $error): ?>
                    <p>- <?php echo $error;?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif ;?>
            </div>

            <div class="row">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form method="post" action="#" id="registerForm">

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Имя или Ник</label>
                      <input type="text" name="name" class="form-control" placeholder="Имя или Ник" value="<?php echo $name; ?>" required>
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  
                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Email адрес</label>
                      <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" required>
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>

                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Пароль</label>
                      <input type="password" name="password" class="form-control" placeholder="Пароль" required >
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  
                  <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                      <label>Повторите пароль</label>
                      <input type="password" name="repassword" class="form-control" placeholder="Повторите пароль" required >
                      <p class="help-block text-danger"></p>
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

          </div>
        </div>
      </main>

      <!-- Sidebar -->
      <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

    </div>
  </div>


  <!-- Footer -->
<?php require_once (ROOT . "/views/layouts/footer.php");?>