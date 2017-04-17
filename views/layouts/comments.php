<?php $articleId = $blogItem['id'];?>

<div class="post-comments">
  <div class="col-sm-12">
    <?php if (User::isGuest()): ; ?>
      <div class="row">
        <h5>Чтобы добавить комментарий, пожалуйста авторизуйтесь н сайте.</h5>
      </div>
    <?php else: ?>
      <div class="row">
        <form action="/user/comments" method="post" id="comment_form">
          <div class="form-group">
            <label>Ваш коментарий</label>
            <textarea name="comment" class="form-control" rows="3" ></textarea>
          </div>
          <input type="hidden" name="article_id" value="<?php echo $articleId;?>">
          <input type="hidden" name="parent_id" value="0">
          <input type="submit" class="btn btn-read-more" name="submit" value="Отправить">
        </form>
      </div>
    <?php endif; ?>

    <div class="row">
      <?php function getArticleComments($comment, $artId){ ?>
        <?php $date = Blog::getDateTimeExplode($comment['date']);?>
        <!-- first comment -->
        <div class="media">
          <div id="comment_id<?php echo $comment['id'];?>" class="media-heading">
            <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#collapse<?php echo $comment['id'];?>" aria-expanded="false" aria-controls="collapseExample">
              <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
            <span class="name"><?php echo $comment['author'];?></span>
            <time datetime="<?php echo $comment['date'];?>">
              <?php
                echo $date['day'] . ' ' . $date['month'] . ' ' . $date['year'] . ' '
                . $date['hours'] . ':' . $date['minutes'] . ':' . $date['seconds'];
              ?>
            </time>
          </div>

          <div class="panel-collapse collapse in" id="collapse<?php echo $comment['id'];?>">

            <div class="media-body">

              <p><?php echo $comment['text'];?></p>

              <div class="comment-meta">
                <?php if (!User::isGuest()): ; ?>
                  <!--<span><a href="#">Удалить</a></span>
                  <span><a href="#">Скрыть</a></span>-->
                  <span>
                    <a class="" role="button" data-toggle="collapse" href="#replyComment<?php echo $comment['id'];?>" aria-expanded="false" aria-controls="collapseExample">Ответить</a>
                  </span>
                  <div class="collapse" id="replyComment<?php echo $comment['id'];?>">
                    <form action="/user/comments" method="post">
                      <div class="form-group">
                        <label for="comment">Ваш коментарий</label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                      </div>
                      <input type="hidden" name="article_id" value="<?php echo $artId;?>">
                      <input type="hidden" name="parent_id" value="<?php echo $comment['id'];?>">
                      <input type="submit" class="btn btn-read-more" name="submit" value="Отправить">
                    </form>
                  </div>
                <?php endif; ?>
              </div>
              <!-- comment-meta -->

              <?php $child = User::getChildComments($comment['id'], $artId);?>

              <?php foreach ($child as $row)
              {
                getArticleComments($row, $artId);
              } ?>

            </div>
          </div>
          <!-- comments -->
        </div>

      <?php } ?>

      <?php if (count($comments)<=0):?>
        Нет коментариев
      <?php endif;?>

      <?php foreach ($comments as $row) {
        getArticleComments($row, $articleId);
      }?>

    </div>
  </div>
  <!-- post-comments -->
</div>