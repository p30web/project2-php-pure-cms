<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Cp;

$Cp->setSidebarActive('crm/ticketsConfig');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/parentSubjects/list_ajax',
        "success_response" => "#nestable_ajax_crm_tickets_parent_subjects",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_crm_tickets_parent_subjects(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/parentSubjects/parentSubject',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_crm_tickets_parent_subjects(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/parentSubjects/remove',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});

    }  
</script>');
$View->head();

?>
<div class="card">
    <div class="card-body">
        <?php
        global $ticketsConfig;
        tab_menus($ticketsConfig, JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/',2);
        modal_create([
                "bg" => "success",
            ]);
            ?>
        <hr/>
        <a href="javascript:;" onclick="nestableEdit_crm_tickets_parent_subjects()" class="btn btn-xs btn-info"><?php __e("add parent Subject") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("crm_tickets_parent_subjects");
        ?>
        <div id="action_body"></div>

    </div>
</div>
<?php
$View->foot();
