<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('crm/ticketsConfig');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js( '
<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/list_ajax',
        "success_response" => "#nestable_ajax_crm_tickets_departments",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_crm_tickets_departments(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/department',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_crm_tickets_departments(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/remove',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});
    } 
    function followers(id) {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/followers',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}     
 function reporters(id) {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/reporters',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}    
function removeFollower(id) {
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/followerRemove',
        "data" => "{id:id}",
        "success_response" => "#action_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $ticketsConfig;
            tab_menus($ticketsConfig, JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/',2);
            ?>
            <hr/>
            <a href="javascript:;" onclick="nestableEdit_crm_tickets_departments()" class="btn btn-xs btn-info"><?php __e("add group") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>

            <?php
            NestableTableInitHtml("crm_tickets_departments");
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