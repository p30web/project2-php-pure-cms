<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $View;
	global $Theme;
	$View->title = "مجله ترابری و لجستیک" . " | " . $View->title;
	$Theme->siteDescription = "آخرین اخبار و اطلاعیه های حوزه حمل و نقل و باربری و راهداری";
	
	$View->head();
?>
    <div class="container blog-container">
        <div class="h-600x h-sm-auto">
            <div class="h-2-3 h-sm-auto oflow-hidden">
				<?php
					global $database;
					$datas = $database->select('jk_data_categories_rel', "dataID", [
						"categoryID" => 80
					]);
					if (sizeof($datas) == 0) {
						$datas = 0;
					}
					
					$getPosts = $database->select('jk_data', '*', [
						"AND" => [
							"id" => $datas,
							"status" => "active",
							"datetime[<=]" => date("Y/m/d H:i:s"),
							"module" => "blog_post"
						],
					]);
					if (isset($getPosts[0])) {
						$getPost = $getPosts[0];
						$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-850-400', false, 'themes/ipin/assets/img/default-255-155.png');
						?>
                        <div class="pb-5 pr-5 pr-sm-0 float-left float-sm-none w-2-3 w-sm-100 h-100 h-sm-300x">
                            <a class="pos-relative h-100 dplay-block"
                               href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">
                                <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                         alt="<?php echo $getPost['title']; ?>"></div>
                                <div class="abs-blr color-white p-20 bg-sm-color-7">
                                    <ul class="list-li-mr-20">
                                        <!--                                    <li>-->
                                        <!--                                        <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                        <!--                                    </li>-->
                                        <!--                                    <li><i class="fa fa-eye"></i> -->
										<?php //echo $getPost['views']; ?><!--</li>-->
                                        <!--                                    <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                    </ul>
                                    <h2 class="mb-15 mb-sm-5 font-sm-13"><b><?php echo $getPost['title']; ?></b></h2>
                                </div><!--abs-blr -->
                            </a><!-- pos-relative -->
                        </div><!-- w-1-3 -->
						<?php
					}
				?>
                <div class="float-left float-sm-none w-1-3 w-sm-100 h-100 h-sm-600x">
					<?php
						if (isset($getPosts[1])) {
							$getPost = $getPosts[1];
							$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-420-195', false, 'themes/ipin/assets/img/default-255-155.png');
							?>
                            <div class="pl-5 pb-5 pl-sm-0 ptb-sm-5 pos-relative h-50">
                                <a class="pos-relative h-100 dplay-block"
                                   href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">

                                    <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                             alt="<?php echo $getPost['title']; ?>">
                                    </div>

                                    <div class="abs-blr color-white p-20 bg-sm-color-7">
                                        <ul class="">
                                            <!--                                        <li>-->
                                            <!--                                            <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                            <!--                                        </li>-->
                                            <!--                                        <li><i class="fa fa-eye"></i> -->
											<?php //echo $getPost['views']; ?><!--</li>-->
                                            <!--                                        <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                        </ul>
                                        <h3 class="mb-10 mb-sm-5"><b><?php echo $getPost['title']; ?></b></h3>
                                    </div><!--abs-blr -->
                                </a><!-- pos-relative -->
                            </div><!-- w-1-3 -->
							<?php
						}
						if (isset($getPosts[2])) {
							$getPost = $getPosts[2];
							$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-420-195', false, 'themes/ipin/assets/img/default-255-155.png');
							?>
                            <div class="pl-5 ptb-5 pl-sm-0 pos-relative h-50">
                                <a class="pos-relative h-100 dplay-block"
                                   href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">

                                    <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                             alt="<?php echo $getPost['title']; ?>">
                                    </div>

                                    <div class="abs-blr color-white p-20 bg-sm-color-7">
                                        <ul class="list-li-mr-20">
                                            <!--                                        <li>-->
                                            <!--                                            <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                            <!--                                        </li>-->
                                            <!--                                        <li><i class="fa fa-eye"></i> -->
											<?php //echo $getPost['views']; ?><!--</li>-->
                                            <!--                                        <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                        </ul>
                                        <h3 class="mb-10 mb-sm-5"><b><?php echo $getPost['title']; ?></b></h3>
                                    </div><!--abs-blr -->
                                </a><!-- pos-relative -->
                            </div><!-- w-1-3 -->
							<?php
						}
					?>
                </div><!-- float-left -->


            </div><!-- h-2-3 -->

            <div class="h-1-3 oflow-hidden">
				<?php
					if (isset($getPosts[3])) {
						$getPost = $getPosts[3];
						$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-420-195', false, 'themes/ipin/assets/img/default-255-155.png');
						?>
                        <div class="pr-5 pr-sm-0 pt-5 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
                            <a class="pos-relative h-100 dplay-block"
                               href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">

                                <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                         alt="<?php echo $getPost['title']; ?>"></div>

                                <div class="abs-blr color-white p-20 bg-sm-color-7">
                                    <ul class="list-li-mr-20">
                                        <!--                                    <li>-->
                                        <!--                                        <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                        <!--                                    </li>-->
                                        <!--                                    <li><i class="fa fa-eye"></i> -->
										<?php //echo $getPost['views']; ?><!--</li>-->
                                        <!--                                    <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                    </ul>
                                    <h4 class="mb-10 mb-sm-5"><b><?php echo $getPost['title']; ?></b></h4>
                                </div><!--abs-blr -->
                            </a><!-- pos-relative -->
                        </div><!-- w-1-3 -->
						<?php
					}
				?>
				<?php
					if (isset($getPosts[4])) {
						$getPost = $getPosts[4];
						$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-420-195', false, 'themes/ipin/assets/img/default-255-155.png');
						?>
                        <div class="plr-5 plr-sm-0 pt-5 pt-sm-10 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
                            <a class="pos-relative h-100 dplay-block"
                               href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">

                                <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                         alt="<?php echo $getPost['title']; ?>"></div>

                                <div class="abs-blr color-white p-20 bg-sm-color-7">
                                    <ul class="list-li-mr-20">
                                        <!--                                    <li>-->
                                        <!--                                        <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                        <!--                                    </li>-->
                                        <!--                                    <li><i class="fa fa-eye"></i> -->
										<?php //echo $getPost['views']; ?><!--</li>-->
                                        <!--                                    <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                    </ul>
                                    <h4 class="mb-10 mb-sm-5"><b><?php echo $getPost['title']; ?></b></h4>
                                </div><!--abs-blr -->
                            </a><!-- pos-relative -->
                        </div><!-- w-1-3 -->
						<?php
					}
				?>
				<?php
					if (isset($getPosts[5])) {
						$getPost = $getPosts[5];
						$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'slider-420-195', false, 'themes/ipin/assets/img/default-255-155.png');
						?>
                        <div class="pl-5 pl-sm-0 pt-5 pt-sm-10 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
                            <a class="pos-relative h-100 dplay-block"
                               href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>">

                                <div class="img-bg bg-grad-layer-6"><img src="/<?php echo $thumbnail; ?>"
                                                                         alt="<?php echo $getPost['title']; ?>"></div>

                                <div class="abs-blr color-white p-20 bg-sm-color-7">
                                    <ul class="list-li-mr-20">
                                        <!--                                    <li>-->
                                        <!--                                        <i class="fa fa-calendar-alt"></i> --><?php //echo \Joonika\Idate\date_int("Y/m/d", $getPost['datetime']) ?>
                                        <!--                                    </li>-->
                                        <!--                                    <li><i class="fa fa-eye"></i> -->
										<?php //echo $getPost['views']; ?><!--</li>-->
                                        <!--                                    <li><i class="fa fa-comment-alt"></i> 0</li>-->
                                    </ul>
                                    <h4 class="mb-10 mb-sm-5"><b><?php echo $getPost['title']; ?></b></h4>
                                </div><!--abs-blr -->
                            </a><!-- pos-relative -->
                        </div><!-- w-1-3 -->
						<?php
					}
				?>
            </div><!-- h-2-3 -->
        </div><!-- h-100vh -->
    </div><!-- container -->

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 mt-4">
                <div class="row">
                    <div class="col-12 card widget sidebar-wideget">
                        <div class="sidebar-title text-right">
                            <h2 class="mb-0">پربازدیدترین مطالب</h2>
                        </div>
                    </div>
					<?php
						global $database;
						$getPosts = $database->select('jk_data', '*', [
							"AND" => [
								"status" => "active",
								"datetime[<=]" => date("Y/m/d H:i:s"),
								"module" => "blog_post"
							],
							"ORDER" => ["views" => "DESC"],
							"LIMIT" => [0, 6],
						]);
						if (sizeof($getPosts) >= 1) {
							foreach ($getPosts as $getPost) {
								$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'th-255-155', false, 'themes/ipin/assets/img/default-255-155.png');
								?>
                                <a href="<?php echo JK_DOMAIN_LANG . $getPost['slug']; ?>" class="col-12 col-md-12">
                                    <div class="card mb-4 shadow-sm">
                                        <img class="card-img-top" src="/<?php echo $thumbnail; ?>"
                                             alt="<?php echo $getPost['title'] ?>">
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $getPost['title'] ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn btn-warning btn-sm">مشاهده</div>

                                                <small class="text-muted">زمان تقریبی
                                                    مطالعه: <?php echo readingTime($getPost['text']) . "دقیقه " ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
								<?php
							}
						}
					?>
                </div>
            </div>
            <div class="col-12 col-md-6 mt-4">
                <div class="row">
                    <div class="col-12 card widget sidebar-wideget">
                        <div class="sidebar-title text-right">
                            <h1 class="small"><?php echo $Theme->siteDescription ?></h1>
                        </div>
                    </div>
					<?php
						global $database;
						$getPosts = $database->select('jk_data', '*', [
							"AND" => [
								"status" => "active",
								"datetime[<=]" => date("Y/m/d H:i:s"),
								"module" => "blog_post"
							],
							"ORDER" => ["id" => "DESC"],
							"LIMIT" => [0, 10],
						]);
						$datalast = "0";
						if (sizeof($getPosts) >= 1) {
							foreach ($getPosts as $getPost) {
								$thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'th-255-155', false, 'themes/ipin/assets/img/default-255-155.png');
								?>
                                <a href="<?php echo JK_DOMAIN_LANG . $getPost['slug']; ?>" class="col-12 col-md-12">
                                    <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                                        <div class="card-body d-flex flex-column align-items-start">
                                            <strong class="d-inline-block mb-2 text-primary"><?php echo $getPost['title'] ?></strong>
                                            <div class="mb-1 text-muted"><?php echo \Joonika\Idate\date_int("d F Y", $getPost['datetime']); ?></div>
                                            <p class="card-text mb-auto"><?php echo $getPost['description'] ?></p>
                                            <div class="btn btn-warning btn-sm">مشاهده</div>
                                        </div>
                                        <img class="card-img-right flex-auto d-none d-lg-block "
                                             style="width: 273px;height: 170px;" src="/<?php echo $thumbnail; ?>"
                                             alt="<?php echo $getPost['title'] ?>">
                                    </div>
                                </a>
								<?php
								$dataLast = $getPost['id'];
							}
						}
					?>
                </div>
                <div id="load_more_blog_body" class="row"></div>
                <div class="mb-2">
                    <button class="alert-link" id="load_more_blog" onclick="load_more_blog()"
                            data-last="<?php echo $dataLast; ?>">
                        <i class="fa fa-arrow-down"></i>
                        مشاهده مطالب بیشتر

                        <i class="fa fa-square small text-warning"></i>
                        <i class="fa fa-square small"></i>
                        <i class="fa fa-square small"></i>
                    </button>
                </div>
                <div class="sticky-stopper"></div>
            </div>
            <div class="col-12 col-md-3 mt-4 ">
				<?php
					$View->footer_js('<script>
function load_more_blog() {
      var lastID=$("#load_more_blog").attr("data-last");
            ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'themeAjax/load_more_blog',
							"data" => "{lastID:lastID}",
							"success_response" => "#load_more_blog_body",
							"loading" => ['iclass-size' => 1, 'elem' => 'span']
						]) . '
}
function reSticky(){
  var $sticky = $(\'.sticky\');
  var $stickyrStopper = $(\'.sticky-stopper\');
    if ($(window).width() > 800) {
  if (!!$sticky.offset()) { // make sure ".sticky" element exists

    var generalSidebarHeight = $sticky.innerHeight();
    var stickyTop = $sticky.offset().top;
    var stickOffset = 0;
    var stickyStopperPosition = $stickyrStopper.offset().top;
    var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
    var diff = stopPoint + stickOffset;

    $(window).scroll(function(){ // scroll event
      var windowTop = $(window).scrollTop(); // returns number

      if (stopPoint < windowTop) {
          $sticky.css({ position: \'relative\', top: \'initial\' });
      } else if (stickyTop < windowTop+stickOffset) {
          $sticky.css({ position: \'fixed\', top: stickOffset+50 });
      } else {
          $sticky.css({position: \'relative\', top: \'initial\'});
      }
    });

  }
  }
          }
          reSticky();
</script>');
				?>
                <div class="sticky">
                    <div class="card card-body widget sidebar-wideget widget_categories ">
                        <div class="sidebar-title text-right">
                            <h2>دسته بندی ها</h2>
                        </div>
                        <ul>
							<?php
								$getPosts = $database->select('jk_data', '*', [
									"AND" => [
										"status" => "active",
										"datetime[<=]" => date("Y/m/d H:i:s"),
										"module" => "blog_category"
									],
								]);
								if (sizeof($getPosts) >= 1) {
									foreach ($getPosts as $getPost) {
										?>
                                        <li>
                                            <a href="<?php echo JK_DOMAIN_LANG . $getPost['slug'] ?>"><?php echo $getPost['title'] ?></a>
                                        </li>
										<?php
									}
								}
							?>
                        </ul>
                    </div>


                    <div class="widget sidebar-wideget widget_categories">
                        <div class="sidebar-title text-right">
                            <h2>پست های اینستاگرام</h2>
                            <div class="row">
                                <div class="col-6 margin-bottom-20px"><a href="https://www.instagram.com/ipinbar/"><img
                                                src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/ipin.jpg"
                                                alt=""></a></div>
                                <div class="col-6 margin-bottom-20px"><a href="https://www.instagram.com/ipinbar/"><img
                                                src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/ipin2.jpg"
                                                alt=""></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php
	$View->foot();
