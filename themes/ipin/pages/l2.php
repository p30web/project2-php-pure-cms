<?php
if(!defined('jk')) die('Access Not Allowed !');
if(!isset($data['id'])){
    error404();
    die;
}
global $View;
global $Theme;
$Theme->siteDescription=$data['description'];
$thumbnail=\Joonika\Upload\getfile($data['thumbnail'],false,'th-255-155','file','themes/ipin/assets/img/default-255-155.png');
\Joonika\Modules\Blog\datePlusView($data['id']);
$VersionStyles='8';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $View->getTitle(); ?></title>
    <meta name="keywords" content="<?php echo $Theme->siteKeywords; ?>"/>
    <meta name="description" content="<?php echo $Theme->siteDescription; ?>"/>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta name="copyright" content="ipinbar">
    <meta name="language" content="fa">
    <meta name="google" content="notranslate">

    <meta name="robots" content="index follow">

    <meta name="googlebot" content="index follow">
    <meta name="samandehi" content="712692104"/>
    <meta property="og:title" content="<?php echo $View->getTitle(); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://ipinbar.net"/>
    <meta property="og:image" content="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/logo.png"/>
    <meta property="og:site_name" content="<?php echo $Theme->siteTitle; ?>"/>
    <meta property="og:description" content="<?php echo $Theme->siteDescription; ?>"/>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="/themes/ipin/assets/landing2/css/bootstrap.min.css?=v<?php echo $VersionStyles; ?>">
    <link rel="stylesheet" href="/themes/ipin/assets/landing2/css/style.css?=v<?php echo $VersionStyles; ?>">
    <link rel="stylesheet" href="/themes/ipin/assets/landing2/css/responsive.css?=v<?php echo $VersionStyles; ?>">
    <link rel="stylesheet" href="https://cdn.ipinbar.net/themes/ipin/assets/fa/css/all.css">
    <!--style-->

</head>
<body>
<div id="intro">
    <div class="bg"></div>
    <div class="content">
        <img src="/themes/ipin/assets/landing2/img/special_img.svg" alt="">
        <h1 class="title">سامانه مدیریت یکپارچه حمل‌ونقل</h1>
        <h2 class="description" style="font-size:22px;">حمل بار با کرایه عادلانه بدون کمیسیون</h2>
        <div class="download-app-slide">
            <h3 class="choose-version mt-5">لطفا یکی از گزینه های زیر را انتخاب نمایید.</h3>
            <div class="text-center">
                <a class="app_links" href="#modal_dl_client" data-toggle="modal" data-target="#modal_dl_client">
                    <p>صاحب بار هستم</p>
                    <ul>
                        <li><span class="google_play"></span></li>
                        <li><span class="app_store"></span></li>
                    </ul>
                </a>
                <a class="app_links" href="#modal_dl_driver" data-toggle="modal" data-target="#modal_dl_driver">
                    <p> راننده هستم</p>
                    <ul>
                        <li><span class="google_play"></span></li>
                        <li><span class="app_store"></span></li>
                    </ul>
                </a>

            </div>
            <div class="text-center">
                <span class="arrow"></span>
            </div>
        </div>

        </div>

</div>

<nav class="clearfix">
    <div class="wrapper">
        <ul id="menu">
            <li><a href="https://ipinbar.net/">صفحه اصلی سایت</a></li>
            <li class="register"><a target="_blank" href="https://www.instagram.com/ipinbar">#آی‌پینی_شو</a></li>
        </ul>
        <a href="https://ipinbar.net/"><img src="/themes/ipin/assets/landing2/img/ipinLogo.svg" alt="" id="logo"></a>
    </div>
</nav>

<div id="items">
    <div class="wrapper">


        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a  href="javascript:" data-toggle="modal" data-target="#modal_dl_driver">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">بار خوب</span>
                        <span class="text">کرایه خوب</span>
                        <span class="text">دوسر بار</span>

                    </div>
                </div>
                <img src="/themes/ipin/assets/landing2/img/1.jpg" alt="">
                <h4>اپلیکیشن ویژه رانندگان</h4>

                <div  class="btn">دانلود</div>
        </div>


        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a  href="javascript:" data-toggle="modal" data-target="#modal_dl_client">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">سرعت</span>
                        <span class="text">امنیت</span>
                        <span class="text">اطمینان</span>
                    </div>

                </div>
                <img src="/themes/ipin/assets/landing2/img/2.jpg" alt="">
                <h4>اپلیکیشن ویژه صاحبان بار</h4>
                <a  href="javascript:;" data-toggle="modal" data-target=".download-user-modal" class="btn">دانلود</a>
            </a>
        </div>
        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href="https://ipinbar.net/fa/%D8%A8%DB%8C%D9%85%D9%87-%D8%B4%D8%AE%D8%B5-%D8%AB%D8%A7%D9%84%D8%AB-%D9%88-%D8%A8%D8%AF%D9%86%D9%87">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">تا</span>
                        <div class="count">۴۰٪<span class="text small"></span></div>
                        <span class="text">تخفیف</span>
                    </div>
                </div>

                <img src="/themes/ipin/assets/landing2/img/4.jpg" alt="">
                <h4>بیمه شخص ثالث و بدنه اقساطی</h4>
                <a target="_blank" href="https://ipinbar.net/fa/%D8%A8%DB%8C%D9%85%D9%87-%D8%B4%D8%AE%D8%B5-%D8%AB%D8%A7%D9%84%D8%AB-%D9%88-%D8%A8%D8%AF%D9%86%D9%87" class="btn">بیشتر</a>
            </a>
        </div>

        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href="https://ipinbar.net/fa/%D9%85%D9%88%D8%B3%D8%B3%D8%A7%D8%AA-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">امنیت ‌‌شغلی</span>
                        <span class="text">فراوانی ‌بار‌</span>
                        <span class="text">درآمدبیشتر</span>
                    </div>

                </div>
                <img src="/themes/ipin/assets/landing2/img/3.jpg" alt="">
                <h4>پنل ویژه موسسات حمل‌ونقل</h4>
                <a target="_blank" href="https://ipinbar.net/fa/%D9%85%D9%88%D8%B3%D8%B3%D8%A7%D8%AA-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84" class="btn">ورود</a>
            </a>
        </div>





        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href="https://cp.ipinbar.net">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">اتوماسیون</span>
                        <span class="text">ترابری‌‌هوشمند‌</span>
                        <span class="text">مدیریت‌ کارآمد</span>
                    </div>
                </div>

                <img src="/themes/ipin/assets/landing2/img/5.jpg" alt="">
                <h4>پنل ویژه شرکت‌ها و کارخانه‌جات</h4>
                <a target="_blank" href="https://cp.ipinbar.net" class="btn">ورود</a>
            </a>
        </div>


        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href="https://ipinbar.net/fa/%D9%86%D9%85%D8%A7%DB%8C%D9%86%D8%AF%DA%AF%DB%8C">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">جذب</span>
                        <span class="text">نمایندگی ‌فعال‌</span>
                        <span class="text">سراسر کشور</span>
                    </div>
                </div>

                <img src="/themes/ipin/assets/landing2/img/6.jpg" alt="">
                <h4>پنل ویژه نمایندگان</h4>
                <a target="_blank" href="https://ipinbar.net/fa/%D9%86%D9%85%D8%A7%DB%8C%D9%86%D8%AF%DA%AF%DB%8C" class="btn">ورود</a>
            </a>
        </div>


        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href="https://ipinbar.net/">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">ارتباط ‌پویا</span>
                        <span class="text">تخفیف ‌و‌</span>
                        <span class="text">قرعه‌کشی</span>
                    </div>
                </div>

                <img src="/themes/ipin/assets/landing2/img/7.jpg" alt="">
                <h4>باشگاه ویژه مشتریان</h4>
                <a target="_blank" href="https://club.ipinbar.net" class="btn">ورود</a>
            </a>
        </div>


        <div class="item" data-sr="move 16px scale up 20%, over 2s">
            <a target="_blank" href=https://ipinbar.net/fa/talar">
                <div class="badge-box">
                    <div class="box"></div>
                    <div class="content-box">
                        <span class="text">توزیع</span>
                        <span class="text">عادلانه‌ و هوشمند‌</span>
                        <span class="text">بار کشوری</span>
                    </div>
                </div>

                <img src="/themes/ipin/assets/landing2/img/8.jpg" alt="">
                <h4>تالار آنلاین اعلان بار کشوری</h4>
                <a target="_blank" href="https://ipinbar.net/fa/talar/" class="btn">بیشتر</a>
            </a>
        </div>






        <div class="modal fade" id="modal_dl_driver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="driver_v">دانلود نسخه رانندگان</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="optionToDownload mb-3 text-right">
                            <li>کرایه حمل عادلانه بار</li>
                            <li>حمل بار بدون کمیسیون</li>
                            <li>بیمه بدنه و ثالث قسطی</li>
                            <li>تا ۴۰ درصد تخفیف بیمه</li>
                        </ul>
                        <div class="d-none d-md-block">
                            لطفا برای دانلود نرم افزار ویژه رانندگان حمل بار و یا ارسال برای دوستان و همکاران خود شماره موبایل مورد نظر را در کادر زیر وارد کرده ،
                            گزینه ارسال را انتخاب نمایید.
                            <form class="mt-2 mb-4" action="" id="form_driver" method="post" autocomplete="off">
                                <div class="input-group">
                                    <input type="text" class="form-control ltr" name="phoneDriver" id="phoneDriver" placeholder="09xxxxxxxx"  aria-describedby="btnGroupAddon">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="input-group-text">ارسال</button>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div id="form_driver_status"></div>
                            <div class="clearfix"></div>
                        </div>
                        <ul class="download-app row justify-content-md-center text-center  ">


                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://goo.gl/jURXSS">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/bazaar-logo.png" class="img img-fluid" alt="دانلود آی‌پین رانندگان حمل بار">
                                    <span class="">دانلود از بازار آی‌پین رانندگان</span>
                                </a>
                            </li>
                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://cp.ipinbar.net/dl/driver.apk">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/android-logo.svg" class="img img-fluid" alt="دانلود آی‌پین رانندگان حمل اثاث">
                                    <span class="">دانلود مستقیم آی‌پین رانندگان</span>
                                </a>
                            </li>
                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://goo.gl/z1RHGF">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/play-logo.png" class="img img-fluid" alt="دانلود اپلیکیشن حمل بار ">
                                    دانلود از گوگل پلی
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade " id="modal_dl_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="client_v">دانلود نسخه صاحبان بار</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="optionToDownload mb-3 text-right">
                            <li>فراخوانی هر نوع خودروی باری مطمئن، ارزان و سریع از سراسر کشور</li>
                            <li>اتوماسیون ترابری با قابلیت کنترل کرایه ها، رصد آنلاین بار</li>
                        </ul>

                        <div class="d-none d-md-block">
                            لطفا برای دانلود نرم افزار ویژه صاحبان بار شماره تلفن صاحب بار را در کادر زیر وارد کرده، گزینه ارسال را انتخاب نمایید و در پیامک ارسال شده روی گوشی بر روی لینک دانلود کلیک کرده و نرم افزار را دریافت نمایید.                    <br/>
                            <form class="mt-2 mb-4" action="" id="form_bar" method="post" autocomplete="off">
                                <div class="input-group">
                                    <input type="text" class="form-control ltr" name="phoneBar" id="phoneBar" placeholder="09xxxxxxxx"  aria-describedby="btnGroupAddon">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="input-group-text">ارسال</button>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div id="form_bar_status"></div>
                            <div class="clearfix"></div>
                        </div>
                        <ul class="download-app row justify-content-md-center text-center  ">
                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://goo.gl/E9vtTd">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/bazaar-logo.png" class="img img-fluid" alt="دانلود اپلیکیشن صاحبان بار">
                                    دانلود از بازار
                                </a>
                            </li>
                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://cp.ipinbar.net/dl/user.apk">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/android-logo.svg" class="img img-fluid" alt="دانلود حمل اثاثیه ویژه صاحبان بار">
                                    دانلود مستقیم صاحب بار
                                </a>
                            </li>
                            <li class="col-12 col-md-8">
                                <a rel="external" target="_blank" href="https://goo.gl/UFfq9h">
                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/play-logo.png" class="img img-fluid" alt="دانلود حمل بار ویژه صاحبان بار">
                                    دانلود از گوگل پلی
                                </a>
                            </li>
<!--                            <li class="col-12 col-md-8">-->
<!--                                <a rel="external" target="_blank" href="https://new.sibapp.com/applications/ipin-users-1">-->
<!--                                    <img src="/themes/ipin/assets/landing2/img/icons-dl/apple-logo.png" class="img img-fluid" alt="دانلود آی‌پین از سیب اپ">-->
<!--                                    دانلود از سیب اپ-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>

                    </div>
                </div>
            </div>
        </div>








    </div>
</div>

<div id="footer" class="clearfix">
    <div class="wrapper">
        <span>شبکه جامع رانندگان شجران</span>
        <a class="btn btn-info" href="http://ipinbar.net/fa">ورود به سایت</a>
    </div>
</div>
<!--script-->
<!--<script src="/themes/ipin/assets/landing2/js/jquery-1.11.3.min.js" type="text/javascript"></script>-->
<script src="https://ipinbar.net/landing/assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="/themes/ipin/assets/landing2/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/themes/ipin/assets/landing2/js/scrollReveal.min.js" type="text/javascript"></script>
<script src="/themes/ipin/assets/landing2/js/init.js?v=<?php echo $VersionStyles; ?>" type="text/javascript"></script>
<!--script-->

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-114539597-1', 'auto');
    ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<script type="text/javascript">!function () {
        function t() {
            var t = document.createElement("script");
            t.type = "text/javascript", t.async = !0, localStorage.getItem("rayToken") ? t.src = "https://app.raychat.io/scripts/js/" + o + "?rid=" + localStorage.getItem("rayToken") + "&href=" + window.location.href : t.src = "https://app.raychat.io/scripts/js/" + o;
            var e = document.getElementsByTagName("script")[0];
            e.parentNode.insertBefore(t, e)
        }

        var e = document, a = window, o = "d97fd942-08b0-4081-81b0-7883a2933bc6";
        "complete" == e.readyState ? t() : a.attachEvent ? a.attachEvent("onload", t) : a.addEventListener("load", t, !1)
    }();</script>
<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//stats.ipinbar.net/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<script>
    $("#form_driver").on("submit",function (e) {
       e.preventDefault();
       var datas=$(this).serialize();
        $("#form_driver_status").html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: "https://ipinbar.net/fa/ipinbar/sendSmsUrl",
            type: "post",
            data: datas,
            success: function (response) {
                $("#form_driver_status").html(response);
            }, error: function () {
                $("#form_driver_status").html("خطا. لطفا مجدد تلاش بفرمایید");
            }
        });
    });
    $("#form_bar").on("submit",function (e) {
       e.preventDefault();
       var datas=$(this).serialize();
        $("#form_bar_status").html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: "https://ipinbar.net/fa/ipinbar/sendSmsUrl",
            type: "post",
            data: datas,
            success: function (response) {
                $("#form_bar_status").html(response);
            }, error: function () {
                $("#form_bar_status").html("خطا. لطفا مجدد تلاش بفرمایید");
            }
        });
    });
</script>
</body>
</html>