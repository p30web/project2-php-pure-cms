<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_roles')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('users/roles');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js( '
<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/roles/list_ajax',
        "success_response" => "#nestable_ajax_jk_roles",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_jk_roles(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/roles/role',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
    function nestableRemove_jk_roles(id) {
      swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{remid:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/roles/remove',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});

    }  
    
    function changeShowInHierarchy(id=\'\') {
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
        "url" => JK_DOMAIN_LANG . 'cp/users/roles/changeShowInHierarchy',
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
            <a href="javascript:;" onclick="nestableEdit_jk_roles()" class="btn btn-xs btn-info"><?php __e("add role") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>

                    <?php
                    NestableTableInitHtml("jk_roles");
                    ?>
<div id="action_body"></div>
            <?php
            modal_create([
                "bg" => "success",
            ]);
            ?>
        </div>
    </div>

<?php

$View->foot();