<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('personnel_timeManagement')) {
		error403();
		die;
	}
	global $View;
	global $Users;
	global $Route;
	global $database;
	global $Cp;
	$Cp->setSidebarActive('personnel/timeManagement');
	$View->footer_js('<script>
function addType(typeID){
      $("#modal_global").modal("show");
      ' . ajax_load([
			"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/index/add',
			"data" => "{typeID:typeID}",
			"success_response" => "#modal_global_body",
			"loading" => ['iclass-size' => 1, 'elem' => 'span']
		]) . '
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
			<?php
				$btns = $database->select('personnel_time_management_types', '*', [
					"status" => "active"
				]);
				if (sizeof($btns) >= 1) {
					foreach ($btns as $btn) {
						$title = langDefineGet(JK_LANG, 'personnel_time_management_types', 'id', $btn['id']);
						
						?>
                        <a href="javascript:;" onclick="addType(<?php echo $btn['id']; ?>)" class="btn btn-outline-info"
                           style="border-color: <?php echo $btn['color']; ?>"><?php echo $title; ?>
                        </a>
						<?php
					}
				}
			?>

            <hr/>
            <table class="table table-xs">
                <thead>
                <tr>
                    <th><?php echo __("title"); ?></th>
                    <th><?php echo __("date and time"); ?></th>
                    <th><?php echo __("description"); ?></th>
                </tr>
                </thead>
                <tbody>
				<?php
					$ids = $database->select("personnel_time_managements", "*", [
						"AND" => [
							"datetime[<>]" => [date("Y/m/d 00:00:00"), date("Y/m/d 23:59:59")],
                            "userID"=>JK_LOGINID
						],
						"ORDER" => ["id" => "DESC"]
					]);
					if (sizeof($ids) >= 1) {
						foreach ($ids as $id) {
							$title = langDefineGet(JK_LANG, 'personnel_time_management_types', 'id', $id['typeID']);
							
							?>
                            <tr>
                                <td><?php echo $title; ?></td>
                                <td><?php echo \Joonika\Idate\date_int("Y/m/d-H:i:s", $id['datetime']); ?></td>
                                <td><?php echo $id['description']; ?></td>
                            </tr>
							<?php
						}
					}
				?>
                </tbody>
            </table>
        </div>
    </div>
<?php
	modal_create([
		"bg" => "success",
	]);
	$View->foot();