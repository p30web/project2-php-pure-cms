<?php //echo "<pre>";
//print_r($a->categoryvideos($_GET['id']));
//echo "</pre>"; ?>
<ul class="categories">

<?php foreach($a->categories() as $id): ?>
<li class="active"><a href="<?= BASE . '/index.php?m=categories&id=' . $id['id'] ?>"><?= $id['name'] ?> <!--<?= $id['videoCnt'] ?>--></span></a></li>
<?php endforeach; ?>
</ul>

<div class="categories_videos">
<?php if(isset($_GET['id']) && in_array($_GET['id'], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22))): ?>

<ul class="video_list categories_videos">
<?php foreach($a->categoryvideos($_GET['id'], 200) as $video): ?>
 <li id="">
   <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>">
     <div class="video_thumb" style="background-image:url('<?= $video['small_poster'] ?>');"></div>
   </a>
   <div class="video_duration"><?= duration($video['duration']) ?></div>
   <div class="video_bazdid"><?php ViewFormat($video['visit_cnt']); ?></div>
   <div class="video_information">
     <a href="<?= BASE.'v/'.$video['uid'].'/'.sanitizeStringForUrl($video['title']) ?>"><?= truncate($video['title'], 42) ?></a>
   </div>
 </li>
<?php endforeach; ?>
</ul>

<div style="clear:both"></div>
<div class="load_more">بارگذاری ویدیوهای بیشتر ...</div>

<?php else: ?>



<?php endif; ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
$(".categories li:first").addClass("selected");
$(".categories li").css("border-left","none");
$(".categories li").hover(function(){$(this).css("border-left","6px solid #F0F0F0");});
$(".categories li").click(function() {
  $(this).addClass("selected");
});
});
</script>