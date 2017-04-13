<?php require_once (ROOT . "/views/layouts/header.php");?>

  <!-- Page Header -->
  <!-- Set your background image for this header on the line below. -->
  <header class="intro-header" style="background-image: url('/template/images/blog-bg.jpg')">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
          <div class="post-heading">
            <h1>Man must explore, and this is exploration at its greatest</h1>
            <h2 class="subheading">Problems look mighty small from 150 miles up</h2>
            <span class="meta">Posted by <a href="#">Start Bootstrap</a> on August 24, 2014</span>
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
                <li><a href="/blog">Блог</a></li>

                <?php foreach($categories as $categoryItem):?>
                  <?php if ($category_id == $categoryItem['id']): ?>
                    <li class="active"><?php echo $categoryItem['name'];?></li>
                  <?php endif; ?>
                <?php endforeach;?>

              </ol>
            </div>

            <!-- Post List -->
            <?php foreach ($articlesInCategory as $articleItem):?>
              <?php $date = Blog::getDateTimeExplode($articleItem['datetime']);?>
              <div class="row">
                <div class="col-md-12 post">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>
                        <strong>
                          <a href="/blog/article/<?php echo $articleItem['id'];?>" class="post-title text-capitalize"><?php echo $articleItem['title'];?></a>
                        </strong>
                      </h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 post-header-line">
                      <span class="glyphicon glyphicon-eye-open"></span> <?php echo $articleItem['views'];?> |
                      <span class="glyphicon glyphicon-user"></span> <a href="#"><?php echo $articleItem['author_name'];?></a> |
                      <span class="glyphicon glyphicon-calendar"></span>
                      <time datetime="<?php echo $articleItem['datetime'];?>">
                        <?php echo $date['day']. ' ' . $date['month'] . ' ' . $date['year'];?> |</time>
                      <span class="glyphicon glyphicon-comment"></span><a href="#"> <?php echo $articleItem['count'];?></a> |
                      <i class="fa fa-hashtag" aria-hidden="true"></i> Тэги :
                      <a href="#" class="label label-info">#Ногти</a>
                      <a href="#" class="label label-info">#Маникюр</a>
                      <a href="#" class="label label-info">#Гель-лак</a>
                      <a href="#" class="label label-info">#Педикюр</a>
                    </div>
                  </div>
                  <div class="row post-content">
                    <div class="col-md-3">
                      <a href="/blog/article/<?php echo $articleItem['id'];?>">
                        <?php
                        $img = explode(',', $articleItem['image']);
                        ?>
                        <img src="<?php echo $img[0];?>" alt="" class="img-responsive center-block">
                      </a>
                    </div>
                    <div class="col-md-9">
                      <p><?php echo mb_substr(strip_tags($articleItem['text']), 0, 120, 'utf-8') . ' ...';?></p>
                      <p><a class="btn btn-read-more" href="/blog/article/<?php echo $articleItem['id'];?>">Подробно &raquo;</a></p>
                    </div>
                  </div>
                </div>
              </div>

            <?php endforeach;?>

          </div>
        </div>
      </main>

      <!-- Sidebar -->
      <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

    </div>
  </div>


<?php require_once (ROOT . "/views/layouts/footer.php");?>