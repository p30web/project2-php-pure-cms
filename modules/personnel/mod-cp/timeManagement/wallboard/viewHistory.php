<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement_wallboard')) {
	error403();
	die;
}
global $database;
?>
<table class="table table-xs responsive small   table-hover table-striped table-bordered">
    <thead>
    <tr>
        <th><?php echo __("action"); ?></th>
        <th><?php echo __("time"); ?></th>
        <th><?php echo __("description"); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php
	$users = $database->select("personnel_time_managements", "*", [
		"AND" => [
			"datetime[<>]" => [date("Y/m/d 00:00:00"), date("Y/m/d 23:59:59")],
            "userID"=>$_POST['userID']
		],
		"ORDER" => ["id" => "ASC"]
	]);

	if (sizeof($users) >= 1) {
		foreach ($users as $user) {
			$title = langDefineGet(JK_LANG, 'personnel_time_management_types', 'id', $user['typeID']);
			?>
            <tr>
                <td><?php echo $title; ?></td>
                <td><?php echo \Joonika\Idate\date_int("H:i:s", $user['datetime']); ?></td>
                <td><?php echo $user['description']; ?></td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
</table>
