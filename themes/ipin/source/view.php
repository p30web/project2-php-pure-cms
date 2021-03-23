<?php
$Array = $a->videohash($_GET['id']);
$Comments = $a->commentByVideo($_GET['id'], 5);
 if($Array == NULL): ?>

null
<?php else:?>
<div class="home_head">
  <div class="home_player">
    <div class="home_title">
      <?= truncate($Array['title'], 120) ?>
    </div>
    <?= $a->view($Array['uid'], 460, 749, 'iframe') ?>
    <?php if(!empty($Array['description'])): ?>
    <div class="video_info_box">
      <?= $Array['description'] ?>
    </div>
    <?php endif; ?>
    <div class="video_comment_box">
      <?php if($Comments == NULL): ?>
      نظری ثبت نشده است.
      <?php else:?>
      <section class="comments">
        <?php foreach($Comments as $comment){ ?>
        <article class="comment"> <a class="comment-img" href="#non"> <img src="<?= $comment['profilePhoto'] ?>" alt="" width="50" height="50"> </a>
          <div class="comment-body">
            <div class="text">
              <p>
                <?= $comment['body'] ?>
              </p>
            </div>
            <p class="attribution">توسط <a href="#non">
              <?= $comment['name'] ?>
              </a> در
              <?= $comment['sdate'] ?>
            </p>
          </div>
        </article>
        <? } ?>
      </section>
      <?php endif; ?>
    </div>
  </div>
  <div class="videoRecom">
    <div class="home_title">ویدیوهای مشابه</div>
    <ul class="video_list">
      <div class="videoRecom">
        <?php foreach($a->videoRecom($_GET['id'], 7) as $video){ ?>
        <li id=""> <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
          <div class="video_thumb" style="background-image:url('<?= $video['small_poster'] ?>');"></div>
          </a>
          <div class="video_duration">
            <?= duration($video['duration']) ?>
          </div>
          <div class="video_information"> <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
            <?= truncate($video['title'], 42) ?>
            </a> </div>
        </li>
        <? } ?>
      </div>
    </ul>
  </div>
</div>
<?php endif; ?>
