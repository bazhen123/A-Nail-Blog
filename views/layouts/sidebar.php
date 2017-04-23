<!-- Sidebar -->
<aside>
  <div class="col-lg-3  col-md-4 col-sm-12">

    <div class="panel">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
        </span>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">Категории</div>
      <div class="list-group">
        <?php foreach($categories as $categoryItem):?>
          <a href="/blog/category/<?=$categoryItem['id'];?>/page-1" class="list-group-item <?php if ($category_id == $categoryItem['id']) echo "active";?>">
            <span class="badge"><?=$categoryItem['count_art'];?></span> <?=$categoryItem['name'];?>
          </a>
        <? endforeach;?>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">Топ статей</div>
      <div class="list-group">
        <?php foreach ($topArticles as $topArticle):?>
          <a class="list-group-item" href="/blog/article/<?=$topArticle['id'];?>">
            <h4 class="list-group-item-heading"><?=$topArticle['title'];?></h4>
            <p class="list-group-item-text"><?=mb_substr(strip_tags($topArticle['text']), 0, 85, 'utf-8') . ' ...';?></p>
          </a>
        <? endforeach;?>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">Последние коментарии</div>
      <div class="panel-body">
        <?php foreach($latestComments as $latestComment):?>
          <?php $user = User::getUserById($latestComment['id']);?>
          <div class="media">
            <div class="media-left">
              <a href="/blog/article/<?=$latestComment['article_id'];?>#comment_id<?=$latestComment['id'];?>">
                <div class="comment_img" style="background-image: url('https://www.gravatar.com/avatar/<?=md5($user['email']);?>?s=64');"></div>
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><?=$latestComment['author'];?></h4>
              <?=mb_substr(strip_tags($latestComment['text']), 0, 45, 'utf-8') . '...';?>
            </div>
          </div>
        <? endforeach;?>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-body">
        <h2>About Author</h2>
        <img src="http://placehold.it/350x500g" class="img-rounded img-responsive center-block" />
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
        <a class="btn btn-read-more" href="#">Подробно &raquo;</a>
      </div>
    </div>

  </div>
</aside>