<div class="home_head">
  <div class="home_player">
    <?php 
  foreach($a->mostviewedvideos(1) as $video){ 
  ?>
    <div class="home_title">
      <?= truncate($video['title'], 120) ?>
    </div>
    <?= $a->view($video['uid'], 460, 749, 'iframe') ?>
  </div>
  <? } ?>
  <div class="home_vitrin">
    <div class="home_title">ویودیوهای ویترین</div>
    <ul class="video_list">
      <div class="videoRecom">
        <?php foreach($a->vitrinvideos(6) as $video){ ?>
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
<div style="clear:both"></div>
پربازدیدترین ویدیوها:
<hr style="margin-top: 10px;border-top: 5px solid #eeeeee;" />
<ul class="video_list">
  <?php foreach($a->mostviewedvideos(150) as $video){ ?>
  <li id=""> <a href="<?= 'https://www.aparat.com/' .'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
    <div class="video_thumb" style="background-image:url('<?= $video['small_poster'] ?>');"></div>
    </a>
    <div class="video_duration">
      <?= duration($video['duration']) ?>
    </div>
      <div class="video_bazdid">
          <?php ViewFormat($video['visit_cnt']);  ?>
      </div>
    <div class="video_information"> <a href="<?php 'https://www.aparat.com' . 'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
      <?= truncate($video['title'], 42) ?>
      </a> </div>
  </li>
  <? } ?>
</ul>
<div style="clear:both"></div>
آخرین ویدیوها:
<hr style="margin-top: 10px;border-top: 5px solid #eeeeee;" />
<ul class="video_list">
  <?php foreach($a->lastvideos(150) as $video){ ?>
  <li id=""> <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
    <div class="video_thumb" style="background-image:url('<?= $video['small_poster'] ?>');"></div>
    </a>
    <div class="video_duration">
      <?= duration($video['duration']) ?>
    </div>
      <div class="video_bazdid">
          <?php ViewFormat($video['visit_cnt']);  ?>
      </div>
    <div class="video_information"> <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
      <?= truncate($video['title'], 42) ?>
      </a> </div>
  </li>
  <? } ?>
</ul>
