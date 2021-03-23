<?php
global $dashboard;
$dashboard->set_widget("users_welcome","users_welcome");
function users_welcome(){
    $txt = sprintf(__("%s %s welcome"),\Joonika\Modules\Users\sexTitleUser(JK_LOGINID),nickName(JK_LOGINID));
?>
    <div class="container">
    <div class="row">
        <div class="card card-body text-center bg-success text-white"><?php echo $txt; ?></div>
        </div>
    </div>
<?php
}