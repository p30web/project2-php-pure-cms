<?php
global $View;
$View->setTitle("باشگاه مشتریان آی‌پین");
$View->head();
?>
    <div class="index-page">

        <div class="page-header header-filter clear-filter purple-filter" data-parallax="true"
             style="background-image: url('<?php echo THEME_CDN; ?>/themes/ipin/assets/club/img/header.png');">
            <div class="container">
                <div class="row mb-5 mt-5">
                    <div class="col-md-8">
                        <div class="brand">
                            <h1 class="mt-3 w3-animate-top">باشگاه مشتریان آی‌پین</h1>
                            <h3 class="mt-5 w3-animate-left">ما به مشتریان خود احترام می گذاریم</h3>
                            <h5 class="mt-5 w3-animate-zoom">یه آی‌پینی همیشه حساب باشگاهشو چک می کنه</h5>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="card card-login">
                            <form class="form" method="post" id="clubLogin" action="">
                                <div class="card-header card-header-primary text-center">
                                    <h4 class="card-title">ورود به باشگاه</h4>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        نام کاربری
                      </span>
                                        </div>
                                        <input type="text" name="username" class="form-control ltr" placeholder="">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        کلمه عبور
                      </span>
                                        </div>
                                        <input type="password" name="password" class="form-control ltr" placeholder="">
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" class="btn btn-primary w-25">ورود</button>
                                </div>
                                <div id="clubLogin_body" style="height: 30px"></div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="main main-raised">
            <div class="section section-basic">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <i class="fa fa-bullseye fa-3x text-info mb-4"></i>
                            <h3>امتیاز کسب کنید</h3>
                            <p>
                                پس از هر سفر امتیاز می گیرید، پس هر سفر شما هم امتیاز داره و هم جایزه
                            </p>
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-shopping-bag fa-3x text-info mb-4"></i>
                            <h3>امتیاز خرج کنید</h3>
                            <p>
                                با امتیازاتون می تونید از محصولات و بسته های متنوع باشگاه استفاده کنید
                            </p>
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-star-of-life fa-3x text-info mb-4"></i>
                            <h3>طرح ها</h3>
                            <p>
                                خبر خوب اینه که هر روز پیشنهادای جذابی رو برای شما آماده کردیم
                            </p>
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-newspaper fa-3x text-info mb-4"></i>
                            <h3>امتیاز کسب کنید</h3>
                            <p>
                                با معرفی باشگاه مشتریان آی‌پین به دوستان، آشنایان و همکارانتون باز هم امتیاز کسب کنید
                            </p>
                        </div>
                        <div class="w-100"></div>
                        <hr/>
                        <div class="col-12">
                            <h3>ما رادر شبکه های اجتماعی دنبال کنید</h3>
                            <div class="">
                                ما برای کسانی را که شبکه های اجتماعی ما را دنبال می کنند هم ارزش قائل هستیم و روزانه به قید قرعه بین فلوور ها و کامنت هاشون قرعه کشی می کنیم و امتیاز می دهیم.
                                <br/>
                                اونوقته که با امتیازاتون می تونید از کلی هدایای باشگاه ما استفاده کنید
                                <div class="mt-3 mb-3">
                                    <!--                        <a href="#" target="_blank"><i class="fab fa-2x fa-facebook"></i></a>-->
                                    <a href="https://twitter.com/ipinbar" target="_blank"><i class="fab fa-3x fa-twitter p-2 text-info"></i></a>
                                    <a href="https://www.instagram.com/ipinbar/" target="_blank"><i class="fab fa-3x fa-instagram p-2"></i></a>
                                    <a href="https://t.me/ipinbar" target="_blank"><i class="fab fa-3x fa-telegram p-2 text-info"></i></a>
                                    <!--                        <a href="#" target="_blank"><i class="fab fa-2x fa-google-plus"></i></a>-->
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="w-100"></div>
                        <div class="text-center col-12 mt-5 text-info">
                            تلفن پشتیبانی: 02162871
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$View->footer_js('<script>
       ' . ajax_load([
        "on" => "submit",
        "formID" => "clubLogin",
        "url" => JK_DOMAIN_LANG . 'club/loginAjax',
        "success_response" => "#clubLogin_body",
        "loading" => [
            "elem" => "span",
            "iclass-size" => "1",
        ]
    ]) . '
$(document).on(\'click\', \'.navbar-toggler\', function() {
  $toggle = $(this);
  $navbar_collapse = $(\'.navbar\').find(\'.navbar-collapse\');

    setTimeout(function() {
      $toggle.addClass(\'toggled\');
    }, 580);


    div = \'<div id="bodyClick"></div>\';
    $(div).appendTo("body").click(function() {
      $(\'html\').removeClass(\'nav-open\');

      if ($(\'nav\').hasClass(\'navbar-absolute\')) {
        $(\'html\').removeClass(\'nav-open-absolute\');
      }
      $(\'#bodyClick\').remove();
      setTimeout(function() {
        $toggle.removeClass(\'toggled\');
      }, 550);
    });

    if ($(\'nav\').hasClass(\'navbar-absolute\')) {
      $(\'html\').addClass(\'nav-open-absolute\');
    }

    $(\'html\').addClass(\'nav-open\');
});

</script>');
$View->foot();