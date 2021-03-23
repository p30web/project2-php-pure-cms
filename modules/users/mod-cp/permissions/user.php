<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$View->footer_js( '
<script>
    
    $("#userID").select2();

' . ajax_load([
        "on" => "change",
        "formID" => "user_search",
        "prevent" => false,
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/user/search',
        "success_response" => "#seach_u_perm",
        "loading" => [
            "text" => '<br/>' . __("please wait")
        ]
    ]) . '
function defaultperms(userID) {
  ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/user/save_perm',
        "success_response" => "#save_result_\"+userID+\"",
        "data" => "{userID:userID}",
        "loading" => [
            "elem" => "span",
        ]
    ]) . '
}
</script>
');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('users/permissions');



$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $permission_tabs;
            tab_menus($permission_tabs, JK_DOMAIN_LANG . 'cp/users/permissions/',2);

            ?>
            <br/>

                    <div class="row">
                        <div class="col-4 offset-4">


<?php
\Joonika\Forms\form_create(['id' => "user_search"]);
$users = $database->select('jk_users', 'id', [
    "status" => 'active'
]);
$array = [];
foreach ($users as $u) {
    $array[$u] = nickName($u);
}
echo \Joonika\Forms\field_select([
    "name" => "userID",
    "ColType" => "12,12",
    "title" => __("user"),
    "first" => true,
    "array" => $array,
    "required" => true
]);
\Joonika\Forms\form_end();
?>


                        </div>
                    </div>

            <div id="seach_u_perm">

            </div>
        </div>
    </div>

<?php

$View->foot();