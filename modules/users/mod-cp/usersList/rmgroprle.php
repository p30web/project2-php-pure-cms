<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $database;
if(isset($_POST['remid'])){
    $database->update('jk_users_groups_rel',[
            "status"=>"inactive"
    ],[
            "id"=>$_POST['remid']
    ]);
    $View->footer_js('<script>
$("#rlg_'.$_POST['remid'].'").remove();
</script>');
    echo $View->footer_js;
}
