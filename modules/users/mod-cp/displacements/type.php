<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$Cp->setSidebarActive('users/displacements');
$View->footer_js( '
<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/types/list_ajax',
        "success_response" => "#nestable_ajax_jk_users_displacements_types",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_jk_users_displacements_types(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/types/type',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}

function changeInactiveOldValue(id=\'\') {
swal({
  title: \'' . __("change type") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{id:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/types/changeOldValue',
        "success_response" => "#action_body",
        "success_response_after" => "shownest();",
        "loading" => [
        ]
    ]) . '
    }
});
}

function changeExtraRoleGroup(id=\'\') {
swal({
  title: \'' . __("change type") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{id:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/types/extraRoleGroup',
        "success_response" => "#action_body",
        "success_response_after" => "shownest();",
        "loading" => [
        ]
    ]) . '
    }
});
}
function changeInactiveUserStatus(id=\'\') {
swal({
  title: \'' . __("change type") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{id:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/types/statusType',
        "success_response" => "#action_body",
        "success_response_after" => "shownest();",
        "loading" => [
        ]
    ]) . '
    }
});
}

</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">

            <?php

            global $displacement_tabs;
            tab_menus($displacement_tabs, JK_DOMAIN_LANG . 'cp/users/displacements/',2);
            modal_create([
                "bg" => "success",
            ]);

            ?>
            <br/>
            <a href="javascript:;" onclick="nestableEdit_jk_users_displacements_types()" class="btn btn-xs btn-info"><?php __e("add type") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>

    <?php
    NestableTableInitHtml("jk_users_displacements_types");
    ?>
<div id="action_body"></div>
        </div>
    </div>

<?php

$View->foot();