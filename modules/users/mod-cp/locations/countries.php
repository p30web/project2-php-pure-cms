<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_countries')) {
    error403();
    die;
}
global $View;
global $Cp;

$Cp->setSidebarActive('users/locations');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/countries/list_ajax',
        "success_response" => "#nestable_ajax_jk_users_locations_countries",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_jk_users_locations_countries(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/countries/country',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableEdit_jk_users_locations_countries_bulk() {
  $("#modal_global").modal("show");
      ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/users/locations/countries/countryBulk',
		"success_response" => "#modal_global_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
}
function nestableRemove_jk_users_locations_countries(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/countries/remove',
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
            global $locations_tabs;
            tab_menus($locations_tabs, JK_DOMAIN_LANG . 'cp/users/locations/',2);
            modal_create([
                "bg" => "success",
            ]);
            ?>
        <hr/>
        <a href="javascript:;" onclick="nestableEdit_jk_users_locations_countries()" class="btn btn-xs btn-info"><?php __e("add country") ?>
            <i class="fa fa-plus-circle"></i></a>
        <a href="javascript:;" onclick="nestableEdit_jk_users_locations_countries_bulk()"
           class="btn btn-xs btn-info"><?php __e("add bulk country") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("jk_users_locations_countries");
        ?>
        <div id="action_body"></div>

    </div>
</div>
<?php
$View->foot();
