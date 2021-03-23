<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_noteModules')) {
	error403();
	die;
}
global $View;
global $Cp;
global $Route;
global $data;
if(isset($Route->path[3])){
	$data['noteID']=$Route->path[3];
	$noteID=$Route->path[3];
}else{
	$noteID=0;
}
$Cp->setSidebarActive('ipinbar/crmSetting');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/noteModules/list_ajax/'.$noteID,
		"success_response" => "#nestable_ajax_ipinbar_note_modules",
		"loading" => [
		]
	]) . '
    }
    shownest();

function nestableEdit_ipinbar_note_modules(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/noteModules/noteModule/'.$noteID,
		"data" => "{id:id}",
		"success_response" => "#modal_global_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
}
function nestableRemove_ipinbar_note_modules(id) {
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
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/noteModules/remove',
		"success_response" => "#action_body",
		"loading" => [
		]
	]) . '
    }
});

    }  
    function changeValModule(typeText,noteSubID) {
            swal({
  title: \'' . __("are you sure ?") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
		"data" => "{typeText:typeText,noteSubID:noteSubID}",
		"url" => JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/noteModules/changeValModule',
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
            <div class="row <?php echo JK_DIRECTION ?>">
                <div class="col-4 offset-4 text-center">
					<?php
					global $database;
					$View->footer_js('<script>
$("#noteID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/ipinbar/crmSetting/noteModules/\'+thisPage;
}
});
</script>');

					$notes=$database->select('crm_tickets_note_modules',"id",[
						"status"=>"active",
                        "ORDER"=>["sort"=>"ASC"]
					]);
					$cts=[];
					if(sizeof($notes)>=1){
						foreach ($notes as $note){
							$cts[$note]=langDefineGet(JK_LANG,'crm_tickets_note_modules','id',$note);
						}
					}
					echo \Joonika\Forms\field_select([
						"name" => "noteID",
						"ColType" => "12,12",
						"title" => __("note module"),
						"first" => true,
						"array" => $cts,
						"required" => true
					]);
					?>
                </div>
            </div>
			<?php
			if($noteID!=0){
				?>
                <hr/>
                <a href="javascript:;" onclick="nestableEdit_ipinbar_note_modules()" class="btn btn-xs btn-info"><?php __e("add sentence") ?>
                    <i class="fa fa-plus-circle"></i></a>
                <hr/>

				<?php
				NestableTableInitHtml("ipinbar_note_modules");
				?>
                <div id="action_body"></div>
				<?php
			}
			?>
        </div>
    </div>
<?php
$View->foot();