<?php require_once (ROOT . "/views/layouts/header.php");?>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('/template/images/blog-bg.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="site-heading">
          <h1>Мои Контакты</h1>
          <span class="subheading">Есть вопросы? У меня есть ответы (может быть).</span>
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
              <li class="active">Контакты</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
              <p>Хотите связаться со мной? Заполните форму ниже, чтобы отправить мне сообщение, и я постараюсь ответить вам в течение 24 часов!</p>

              <form name="sentMessage" id="contactForm" novalidate>
                <div class="row control-group">
                  <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Имя</label>
                    <input type="text" class="form-control" placeholder="Имя" id="name" minlength="3" data-validation-required-message="Пожалуйста введите Ваше имяю" required >
                    <p class="help-block text-danger"></p>
                  </div>
                </div>

                <div class="row control-group">
                  <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Email адрес</label>
                    <input type="email" class="form-control" placeholder="Email" id="email" data-validation-required-message="Пожалуйста введите Ваш Email" required >
                    <p class="help-block text-danger"></p>
                  </div>
                </div>

                <div class="row control-group">
                  <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Сообщение</label>
                    <textarea rows="5" class="form-control" placeholder="Сообщение..." id="message" required data-validation-required-message="Пожилуйста введите текст сообщения"></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <br>

                <div id="success"></div>
                <div class="row">
                  <div class="form-group col-xs-12">
                    <button type="submit" class="btn btn-default">Отправить</button>
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