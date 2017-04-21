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
							<li class="active">Блог</li>
						</ol>
					</div>

					<!-- Post List -->
          <?php foreach ($postList as $postItem):?>
            <?php $date = Blog::getDateTimeExplode($postItem['datetime']);?>
            <div class="row">
              <div class="col-md-12 post">
                <div class="row">
                  <div class="col-md-12">
                    <h4>
                      <strong>
                        <a href="/blog/article/<?php echo $postItem['id'];?>" class="post-title text-capitalize"><?php echo $postItem['title'];?></a>
                      </strong>
                    </h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 post-header-line">
                    <span class="glyphicon glyphicon-eye-open"></span>
                    <span title="Количество просмотров"><?php echo $postItem['views'];?></span> |

                    <span class="glyphicon glyphicon-user"></span>
                    <a href="#" title="Автор статьи"><?php echo $postItem['author_name'];?></a> |

                    <span class="glyphicon glyphicon-calendar" title=""></span>
                    <time datetime="<?php echo $postItem['datetime'];?>" title="Дата публикации">
                      <?php echo $date['day']. ' ' . $date['month'] . ' ' . $date['year'];?></time> |

                    <span class="glyphicon glyphicon-comment"></span>
                    <a href="#" title="Количество комментариев"> <?php echo $postItem['count'];?></a>

                    <i class="fa fa-hashtag" aria-hidden="true"></i> Тэги :
                    <?php $tags = explode(',', $postItem['tags']);?>
                    <?php foreach ($tags as $tag):?>
                      <a href="#" class="label label-info">#<?php echo $tag;?></a>
                    <?php endforeach;?>

                  </div>
                </div>
                <div class="row post-content">
                  <div class="col-md-3">
                    <a href="/blog/article/<?php echo $postItem['id'];?>">
                      <?php
                      $img = explode(',', $postItem['image']);
                      ?>
                      <img src="<?php echo $img[0];?>" alt="" class="img-responsive center-block">
                    </a>
                  </div>
                  <div class="col-md-9">
                    <p><?php echo mb_substr(strip_tags($postItem['text']), 0, 120, 'utf-8') . ' ...';?></p>
                    <p><a class="btn btn-read-more" href="/blog/article/<?php echo $postItem['id'];?>">Подробно &raquo;</a></p>
                  </div>
                </div>
              </div>
            </div>

          <?php endforeach;?>
          <!-- Pagination -->
          <<div id="pagination" class="row">
            <?php echo $pagination->get();?>
          </div>
				</div>
			</div>
		</main>

		<!-- Sidebar -->
    <?php require_once (ROOT . "/views/layouts/sidebar.php");?>

	</div>
</div>


<?php require_once (ROOT . "/views/layouts/footer.php");?>