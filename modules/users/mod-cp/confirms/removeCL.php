<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('users_confirms')) {
    error403();
    die;
}
$continue = true;
if (!isset($_POST['cID'])) {
    $continue = false;
}

if ($continue) {
global $database;
$database->update('jk_users_confirms_corroborant',[
        "status"=>"removed",
],[
        "id"=>$_POST['cID']
]);
$View->footer_js('<script>
reloadDataTable();
</script>');

    echo $View->footer_js;
}