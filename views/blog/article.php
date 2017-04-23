<?php require_once (ROOT . "/views/layouts/header.php");?>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('/template/images/blog-bg.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="post-heading"></div>
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
              <li><a href="/blog/page-1/">Блог</a></li>
              <?php foreach($categories as $categoryItem):?>
                <?php if ($categoryItem['id'] == $blogItem['category_id']):?>
                  <li>
                    <a href="/blog/category/<?=$categoryItem['id'];?>"><?=$categoryItem['name'];?></a>
                  </li>
                <? endif;?>
              <? endforeach;?>
              <li class="active"><?=$blogItem['title'];?></li>
            </ol>
          </div>

          <!-- Article -->

          <div class="row">
            <div class="col-md-12 post">
              <div class="row">
                <div class="col-md-12">
                  <h3>
                    <strong class="post-title text-capitalize"><?=$blogItem['title'];?></strong>
                  </h3>
                </div>
              </div>

              <?php $date = Blog::getDateTimeExplode($blogItem['datetime']);?>
              <div class="row">
                <div class="col-md-12 post-header-line">
                  <span class="glyphicon glyphicon-eye-open"></span> <?=$blogItem['views'];?> |
                  <span class="glyphicon glyphicon-user"></span> <a href="#"><?=$blogItem['author_name'];?></a> |
                  <span class="glyphicon glyphicon-calendar"></span>
                  <time datetime="<?=$blogItem['datetime'];?>">
                    <?=$date['day']. ' ' . $date['month'] . ' ' . $date['year'];?> |</time>
                  <span class="glyphicon glyphicon-comment"></span><a href="#"> <?=$blogItem['count'];?></a> |
                  <i class="fa fa-hashtag" aria-hidden="true"></i> Тэги :
                  <a href="#" class="label label-info">#Ногти</a>
                  <a href="#" class="label label-info">#Маникюр</a>
                  <a href="#" class="label label-info">#Гель-лак</a>
                  <a href="#" class="label label-info">#Педикюр</a>
                </div>
              </div>

              <div class="row post-content">
                <div class="col-md-9 col-lg-7">
                  <?php
                    $images = array();
                    $images = explode(',', $blogItem['image']);
                  ?>
                  <?php foreach ($images as $image):?>
                    <img src="<?=$image;?>" alt="" class="img-responsive center-block">
                  <? endforeach;?>
                </div>
                <div class="col-md-12">
                  <p><?=$blogItem['text'];?></p>
                  <p><a class="btn btn-read-more" href="javascript:history.back();">&laquo; Назад</a></p>
                </div>
              </div>

              <!-- Comments -->
              <h5>Комментарии:</h5>
            </div>
          </div>

          <?php require_once (ROOT . "/views/layouts/comments.php");?>

        </div>
      </div>
    </main>

    <!-- Sidebar -->
    <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

  </div>
</div>
</div>


<!-- Footer -->
<?php require_once (ROOT . "/views/layouts/footer.php");?>
