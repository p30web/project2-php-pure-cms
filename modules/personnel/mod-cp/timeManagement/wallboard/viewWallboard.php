<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement_wallboard')) {
	error403();
	die;
}
global $database;
?>
<table class="table table-sm responsive small   table-hover table-striped table-bordered">
    <thead>
    <tr>
        <th><?php echo __("status"); ?></th>
        <th><?php echo __("user"); ?></th>
        <th><?php echo __("last action"); ?></th>
        <th><?php echo __("last time"); ?></th>
        <th><?php echo __("last description"); ?></th>
        <th><?php echo __("history"); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php
	$users = $database->select("personnel_time_managements", "userID", [
		"datetime[<>]" => [date("Y/m/d 00:00:00"), date("Y/m/d 23:59:59")],
		"GROUP" => "userID",
		"ORDER" => ["id" => "ASC"]
	]);
	if (sizeof($users) >= 1) {
	    new \Joonika\Modules\Personnel\Personnel();
		foreach ($users as $user) {
			$last = $database->get('personnel_time_managements', '*', [
				"userID" => $user,
				"ORDER" => ["id" => "DESC"]
			]);
			$title = langDefineGet(JK_LANG, 'personnel_time_management_types', 'id', $last['typeID']);
			?>
            <tr>
                <td><?php
                    if(\Joonika\Modules\Personnel\timeManagementTypeStatus($last['typeID'])==1){
                        ?><i class="fa fa-circle text-success"></i><?php
                    }else{
	                    ?><i class="fa fa-circle text-danger"></i><?php
                    }
                    ?></td>
                <td><?php echo nickName($user); ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo \Joonika\Idate\date_int("H:i:s", $last['datetime']); ?></td>
                <td><?php echo $last['description']; ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-info" type="button"
                            onclick="viewHistory(<?php echo $user; ?>)"><i class="fa fa-history"></i>
                    </button>
                </td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
</table>
