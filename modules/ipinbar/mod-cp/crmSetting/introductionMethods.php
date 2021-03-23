<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_introductionMethods')) {
	error403();
	die;
}
global $View;
global $Cp;
global $Route;
global $data;
$Cp->setSidebarActive('ipinbar/crmSetting');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/introductionMethods/list_ajax',
		"success_response" => "#nestable_ajax_ipinbar_introduction_methods",
		"loading" => [
		]
	]) . '
    }
    shownest();

function nestableEdit_ipinbar_introduction_methods(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/introductionMethods/noteModule',
		"data" => "{id:id}",
		"success_response" => "#modal_global_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
}
function nestableRemove_ipinbar_introduction_methods(id) {
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
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/introductionMethods/remove',
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
			global $ipinBarCrmSetting;
			tab_menus($ipinBarCrmSetting, JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/',2);
			modal_create([
				"bg" => "success",
			]);
			?>
            <hr/>
                <a href="javascript:;" onclick="nestableEdit_ipinbar_introduction_methods()" class="btn btn-xs btn-info"><?php __e("add") ?>
                    <i class="fa fa-plus-circle"></i></a>
                <hr/>

				<?php
				NestableTableInitHtml("ipinbar_introduction_methods");
				?>
                <div id="action_body"></div>
        </div>
    </div>
<?php
$View->foot();