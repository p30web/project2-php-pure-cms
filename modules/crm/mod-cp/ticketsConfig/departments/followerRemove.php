<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
if (isset($_POST['id'])) {
    global $database;
    $database->update('crm_tickets_departments_followers', [
        "status" => "removed"
    ], [
        "id" => $_POST['id']
    ]);
    $View->footer_js('<script>
$("#followerTr_'.$_POST['id'].'").remove();
</script>');

}
echo $View->footer_js;