<?php require_once(ROOT . "/views/layouts/header.php"); ?>

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
                <li class="active">Аккаунт</li>
              </ol>
            </div>

            <div class="row">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

                <?php if ($user['role'] == 'admin'): ?>
                  <h1>Кабинет администратора.</h1>
                <?php else: ?>
                  <h1>Кабинет пользователя</h1>
                <?php endif; ?>

                <h3 class="text-capitalize">Привет, <?=$user['name']; ?>!</h3>

                <a class="btn btn-link" href="/cabinet/edit">Редактировать данные</a>
                <a class="btn btn-link" href="/user/logout/">Выход</a>

              </div>
            </div>

          </div>
        </div>
      </main>

      <!-- Sidebar -->
      <?php require_once(ROOT . "/views/layouts/sidebar.php"); ?>

    </div>
  </div>

  <!-- Footer -->
<?php require_once(ROOT . "/views/layouts/footer.php"); ?>