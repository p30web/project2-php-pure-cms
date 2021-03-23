<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('personnel_timeManagement_manage')) {
		error403();
		die;
	}
	global $View;
	global $Users;
	global $Route;
	global $database;
	global $Cp;
	$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
	$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
	$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
	$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-" . JK_DIRECTION . ".js");
	$Cp->setSidebarActive('personnel/timeManagement');
	$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
			"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/manage/list_ajax',
			"success_response" => "#nestable_ajax_personnel_time_management_types",
			"loading" => [
			]
		]) . '
    }
    shownest();

function nestableEdit_personnel_time_management_types(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
			"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/manage/type',
			"data" => "{id:id}",
			"success_response" => "#modal_global_body",
			"loading" => ['iclass-size' => 1, 'elem' => 'span']
		]) . '
}
function nestableRemove_personnel_time_management_types(id) {
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
			"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/manage/remove',
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
				global $timeManagementTabs;
				tab_menus($timeManagementTabs, JK_DOMAIN_LANG . 'cp/personnel/timeManagement/', 2);
			?>
            <hr/>
            <hr/>
            <a href="javascript:;" onclick="nestableEdit_personnel_time_management_types()"
               class="btn btn-xs btn-info"><?php __e("add type") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>
			
			<?php
				NestableTableInitHtml("personnel_time_management_types");
			?>
            <div id="action_body"></div>
        </div>
    </div>
<?php
	modal_create([
		"bg" => "success",
	]);
	$View->foot();