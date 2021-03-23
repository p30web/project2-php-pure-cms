<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_config_educational_fields')) {
    error403();
    die;
}
global $View;
global $Cp;

$Cp->setSidebarActive('personnel/config');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFieldsCat/list_ajax',
        "success_response" => "#nestable_ajax_personnel_fields_cats",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_personnel_fields_cats(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFieldsCat/cat',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_personnel_fields_cats(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFieldsCat/remove',
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
        global $personnelConfigTabs;
        tab_menus($personnelConfigTabs, JK_DOMAIN_LANG . 'cp/personnel/config/',2);
            modal_create([
                "bg" => "success",
            ]);
            ?>
        <hr/>
        <a href="javascript:;" onclick="nestableEdit_personnel_fields_cats()" class="btn btn-xs btn-info"><?php __e("add set") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("personnel_fields_cats");
        ?>
        <div id="action_body"></div>

    </div>
</div>
<?php
$View->foot();
