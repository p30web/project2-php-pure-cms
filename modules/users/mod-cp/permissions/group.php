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
        "formID" => "group_search",
        "prevent" => false,
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/group/search',
        "success_response" => "#seach_perm",
        "loading" => [
            "text" => '<br/>' . __("please wait")
        ]
    ]) . '
function defaultperms(groupID,roleID) {
  ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/group/save_perm',
        "success_response" => "#save_result_\"+groupID+\"_\"+groupID+\"",
        "data" => "{groupID:groupID,roleID:roleID}",
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
\Joonika\Forms\form_create(['id' => "group_search"]);

$groups = \Joonika\Modules\Users\groupsSubGroupsArray([],0, '' );

echo \Joonika\Forms\field_select([
    "name" => "groupID",
    "ColType" => "12,12",
    "title" => __("group"),
    "first" => true,
    "array" => $groups,
    "required" => true
]);

$roles = \Joonika\Modules\Users\rolesArray();
echo \Joonika\Forms\field_select([
    "name" => "roleID",
    "ColType" => "12,12",
    "title" => __("role"),
    "first" => true,
    "array" => $roles,
    "required" => true
]);
\Joonika\Forms\form_end();
?>


                        </div>
                    </div>

            <div id="seach_perm">

            </div>
        </div>
    </div>

<?php

$View->foot();