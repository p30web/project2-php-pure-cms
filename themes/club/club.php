<?php
global $Route;
$continue=true;
$userID=0;
if(!isset($Route->path[1])){
    $continue=false;
}
if($continue){
$userID=$Route->path[1];
    if($userID=="0"){
        $continue=false;
    }
}
if($continue){
$curl2 = curl_init();
curl_setopt_array($curl2, array(
    CURLOPT_PORT => "8443",
    CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPersonId/".$userID,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Postman-Token: 23bda599-7f60-414d-9c7d-95b7af335d41",
        "cache-control: no-cache"
    ),
));
$response2 = curl_exec($curl2);
$err2=curl_error($curl2);
if($err2){
    $continue=false;
}
}
if($continue){
    $res=json_decode($response2,true);
    if(!isset($res['userAccount']['username'])){
        $continue=false;
    }
}
global $View;
global $database;
$View->head_file=__DIR__.DS.'incInApp'.DS.'header.php';
$View->foot_file=__DIR__.DS.'incInApp'.DS.'footer.php';
$View->setTitle("باشگاه مشتریان آی‌پین");
$View->head();
if(!$continue){
echo alertDanger("مشکل در دریافت اطلاعات باشگاه مشتریان");
}else{
    $checkuser=$database->get('clients_ipinbar',"*",[
        "username"=>$res['userAccount']['username'],
    ]);


    if(isset($checkuser['id'])){

        $database->update('clients_ipinbar',[
            "username" => $res['userAccount']['username'],
            "lastLoginApp" => date("Y/m/d H:i:s"),
            "staticRole"=>$res['userAccount']['userAccountType']['staticRole'],
            "firstName"=>$res['firstNameFa'],
            "lastName"=>$res['lastNameFa'],
            "mobile"=>$res['phone'],
            ],[
            "id"=>$checkuser['id']
        ]);
        $clientID=$checkuser['id'];
    }else {
        $database->insert('clients_ipinbar', [
            "username" => $res['userAccount']['username'],
            "lastLoginApp" => date("Y/m/d H:i:s"),
            "staticRole"=>$res['userAccount']['userAccountType']['staticRole'],
            "firstName"=>$res['firstNameFa'],
            "lastName"=>$res['lastNameFa'],
            "mobile"=>$res['phone'],
        ]);
        $clientID = $database->id();
    }

    $client = $database->get('clients_ipinbar', '*', [
        "id" => $clientID
    ]);
    $_SESSION['clubUser']=$clientID;
?>
    <div class="index-page">
        <div class="container">
            <div class="card  mt-1">
                <div class="card-header bg-info text-white">
                    <div class="row">
                        <div class="col-12 col-md-8 text-center">
                            <?php
                            echo clientRoleTitle($client['staticRole']);
                            ?> <strong class=""><?php echo $client['firstName'] . ' ' . $client['lastName']; ?></strong>
                            به باشگاه مشتریان شبکه جامع رانندگان خوش آمدید
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            آخرین ورود شما : ساعت
                            <?php echo \Joonika\Idate\date_int("H:i", $client['lastLoginApp']); ?>
                            در
                            <?php echo \Joonika\Idate\date_int("Y/m/d", $client['lastLoginApp']); ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card current-score shadow">
                                <div class="card-body text-center p-0 pt-4">
                                    <h3 class="text-success"><?php echo clientType($client['staticRole']);; ?></h3>
                                    <div class="gift">
                                        <h3 class="value ng-binding"><?php echo $client['points']; ?></h3>
                                        <div class="label text-white">امتیاز فعلی شما</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8 col-12">
                            <div class="card current-score shadow">
                                <div class="card-header text-center">
                                    آمار امتیازات شما
                                </div>
                                <?php
                                $p=$database->sum("club_points","point",[
                                    "AND" => [
                                        "userSource" => "clients_ipinbar",
                                        "status" => "active",
                                        "type" => "p",
                                        "userid" => $clientID,
                                    ]
                                ]);
                                if(!$p){
                                    $p=0;
                                }
                                $n=$database->sum("club_points","point",[
                                    "AND" => [
                                        "userSource" => "clients_ipinbar",
                                        "status" => "active",
                                        "type" => "n",
                                        "userid" => $clientID,
                                    ]
                                ]);
                                if(!$n){
                                    $n=0;
                                }
                                ?>
                                <div class="card-body text-center p-3">
                                    <div class="bg2-success rounded p-3">
                                        <div class="float-right">کل امتیازات اخذ شده</div>
                                        <div class="float-left"><?php echo $p; ?></div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="bg2-danger rounded p-3">
                                        <div class="float-right">کل امتیازات مصرف شده</div>
                                        <div class="float-left"><?php echo $n; ?></div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="bg-success rounded p-3 text-white">
                                        <div class="float-right">امتیاز باقی مانده</div>
                                        <div class="float-left"><?php echo $client['points']; ?></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="w-100"></div>
                        <div class="col-md-12 mt-4">
                            <hr/>
                            <h5 class="text-center text-success">بسته های موجود</h5>

                            <div class="row">
                                <div class="col-6 col-md-2 mb-2">
                                    <div class="card">
                                        <img class="card-img-top" src="<?php echo THEME_CDN; ?>/themes/ipin/assets/club/img/logo-mci.png"
                                             alt="">
                                        <div class="card-body text-center p-0">
                                            <h5 class="card-title">شارژ سیم کارت اعتباری</h5>
                                            <p class="card-text">ویژه همراه اول</p>
                                            <button type="button" class="btn btn-primary btn-block" onclick="charge_app('mci')">شارژ شو </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-2">
                                    <div class="card">
                                        <img class="card-img-top" src="<?php echo THEME_CDN; ?>/themes/ipin/assets/club/img/logo-mci.png"
                                             alt="">
                                        <div class="card-body text-center p-0">
                                            <h5 class="card-title">بسته های اینترنتی </h5>
                                            <p class="card-text">ویژه همراه اول</p>
                                            <a href="#" class="btn btn-primary btn-block disabled">فعالسازی <span class="small text-white">بزودی</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-2">
                                    <div class="card">
                                        <img class="card-img-top" src="<?php echo THEME_CDN; ?>/themes/ipin/assets/club/img/logo-irancell.png"
                                             alt="">
                                        <div class="card-body text-center p-0">
                                            <h5 class="card-title">شارژ سیم کارت اعتباری</h5>
                                            <p class="card-text">ویژه ایرانسل</p>
                                            <button type="button" class="btn btn-primary btn-block" onclick="charge_app('mtn')">شارژ شو </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-2">
                                    <div class="card">
                                        <img class="card-img-top" src="<?php echo THEME_CDN; ?>/themes/ipin/assets/club/img/logo-irancell.png"
                                             alt="">
                                        <div class="card-body text-center p-0">
                                            <h5 class="card-title">بسته های اینترنتی </h5>
                                            <p class="card-text">ویژه ایرانسل</p>
                                            <a href="#" class="btn btn-primary btn-block disabled">فعالسازی <span class="small text-white">بزودی</span></a>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="col-12 col-md-4">-->
<!--                                    <div class="card">-->
<!--                                        <div class="card-body text-center">-->
<!--                                            <p class="mb-4"><i class="fa fa-retweet fa-6x text-success  "></i></p>-->
<!--                                            <h5 class="card-title mb-4">تبدیل امتیاز به اعتبار </h5>-->
<!--                                            <p class="card-text mb-5">با تبدیل امتیاز به اعتبار مبلغ معادل امتیاز شما به-->
<!--                                                حساب کاربری شما انتقال می یابد</p>-->
<!--                                            <a href="#" class="btn btn-primary btn-block disabled">تبدیل <span class="small text-white">بزودی</span></a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>

                            <hr/>
                            <h5 class="text-center text-info">سابقه امتیاز ها</h5>
                            <div class="text-center mb-3">امتیاز باقیمانده: <strong><?php echo $client['points']; ?></strong></div>
                            <div class="row rtl">
                                <div class="col-md-8 offset-md-2">
                                    <table class="table table-info table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">توضیحات</th>
                                            <th class="text-center">تاریخ</th>
                                            <th class="text-center">ساعت</th>
                                            <th class="text-center">میزان امتیاز</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <?php
                                        $club_points = $database->select('club_points', '*', [
                                            "AND" => [
                                                "userSource" => "clients_ipinbar",
                                                "status" => "active",
                                                "userid" => $client['id'],
                                            ]
                                        ]);
                                        if(sizeof($club_points)>=1){
                                            foreach ($club_points as $club_point){
                                                if($club_point['type']=='p'){
                                                    $cls="success";
                                                }else{
                                                    $cls="danger";
                                                }
                                                ?>
                                                <tr class="bg2-<?php echo $cls ?>">
                                                    <td><?php echo $club_point['description']; ?></td>
                                                    <td><?php echo \Joonika\Idate\date_int("Y/m/d",$club_point['datetime']); ?></td>
                                                    <td><?php echo \Joonika\Idate\date_int("H:i",$club_point['datetime']); ?></td>
                                                    <td><?php echo $club_point['point']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

<?php
modal_create([
    "bg" => "success",
]);

$View->footer_js('<script>
       ' . ajax_load([
        "on" => "submit",
        "formID" => "clubLogin",
        "url" => JK_DOMAIN_LANG . 'club/loginAjax',
        "success_response" => "#clubLogin_body",
        "loading" => [
            "elem" => "span",
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

function charge_app(operator){
    $("#modal_global").modal("show");
     ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'club/chargeApp',
        "data" => "{op:operator}",
        "success_response" => "#modal_global_body",
        "loading" => [
            "elem" => "span",
        ]
    ]) . '
}

</script>');
    $View->foot();
}
