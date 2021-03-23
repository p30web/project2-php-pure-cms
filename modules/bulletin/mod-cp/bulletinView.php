<?php
global $dashboard;
$dashboard->set_widget("list_announce","list_announce");
// bulletin view goes here
global $Bulletin;
if(isset($Bulletin)){
    $storage=$Bulletin->list_announce(true);
}
function list_announce(){
    $txt = sprintf(__("%s %s welcome"),\Joonika\Modules\Users\sexTitleUser(JK_LOGINID),nickName(JK_LOGINID));
    ?>
    <div class="card">
        <div class="card-header">
            <div class="card-body text-center text-white"><?php //bulletin announce or message goes here ?></div>
        </div>
    </div>
    <?php
}