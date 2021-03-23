<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;
$View->title="تالار اعلان بار | ".$View->title;
$Theme->siteDescription="تابلو اعلان بار شبکه جامع رانندگان با مشارکت تولیدکنندگان و شرکت های حمل و نقل معتبر سراسر کشور";
$View->head();
?>
    <div class="page-title">
        <div class="container">
            <div class="pt-5 pb-4">
                <h1 class="page-title-h2">تالار اعلان بار سراسری</h1>
                <div class="page-sub-title pt-3">تابلو اعلان بار شبکه جامع رانندگان با مشارکت تولیدکنندگان و شرکت های حمل و نقل معتبر سراسر کشور</div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="row">
        <div class="slideBackGround mt-3">
            <i class="pin"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/pich.png" alt="ipin"></i>
            <i class="pin2"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/pich.png" alt="shajaran"></i>
            <i class="pin3"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/pich.png" alt="تابلو اعلان بار"></i>
            <i class="pin4"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/pich.png" alt="آسان بار"></i>
            <div class="text-center w-100 rowTable padding-10px bg-icons">
                <div><div class="text-shadow text-center">
                        <div class="row rtl">
                            <div class="col-6 offset-3 text-center">
                                <h3 class="table-title">
                                    <img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/icons/bars.svg" alt="سامانه اعلان بار سراسری" width="20" class="img d-none d-md-inline">
                                    پایانه اعلان بار کشوری آی‌پین
                                    <img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/icons/bars.svg" alt="پایانه اعلان بار" width="20" class="img d-none d-md-inline">
                                </h3>
                            </div>
                            <div class="col-3">
                                <div class="table-title d-none d-md-inline text-white" id="time_bars_table"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="first">
                <?php
                $View->footer_js('<script>
getdata_table_bar();
setInterval(function(){ 
getdata_table_bar();
 }, 5000);

function getdata_table_bar() {
      $( "div[id^=\'get_bar_table_\']" ).each(function() {
  var thistype=$(this).attr("data-type");
  var thisid=$(this).attr("data-get");
      var datas={getid:thisid,gettype:thistype};
    
    $.ajax({
        url: "https://ipinbar.net/fa/themeAjax/bar_table",
        type: "post",
        data: datas,
        success: function (response) {
            $("#get_bar_table_"+thistype+"").html(response);
        }, error: function () {
}
    });

});
}



                
                function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById(\'time_bars_table\').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
    startTime();
                
</script>');
                ?>
                <div id="bar_tables">
                    <div class="row">
                        <?php
                        $carTypeT=[
                            1=>"وانت",
                            2=>"نیسان",
                            3=>"خاور 3 تنی",
                            4=>"خاور 5 تنی",
                            5=>"911- بادسان",
                            6=>"10 تن - تک",
                            7=>"15 تن - جفت",
                            8=>"تریلر",
                            9=>"کمر شکن",
                            10=>"بوژی",
                        ];
                        for($i=1;$i<=10;$i++){
                            $col1='<img src="'.THEME_CDN.'/themes/ipin/assets/bar_table_car/'.$i.'.png" alt="رانندگان '.$carTypeT[$i].'" class="img"> '.$carTypeT[$i];
                            ?>
                            <div class="col-12">
                                <div class="container">
                                    <div class="row border-bottom p-2">
                                        <div class="col-12 col-md-4 text-right"><?php echo $col1; ?></div>
                                        <div class="col-12 col-md-8">
                                            <div class="row" id="get_bar_table_<?php echo $i; ?>" data-get="0" data-type="<?php echo $i; ?>">
                                                <div class="col-12 col-md-4"><i class="fa fa-spinner fa-spin"></i></div>
                                                <div class="col-12 col-md-4"><i class="fa fa-spinner fa-spin"></i></div>
                                                <div class="col-12 col-md-4"><i class="fa fa-spinner fa-spin"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="w-100 mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
$View->foot();
