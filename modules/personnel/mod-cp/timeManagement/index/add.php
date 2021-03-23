<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('personnel_timeManagement')) {
		error403();
		die;
	}
	global $View;
	global $database;
	$View->footer_js('<script>
' . ajax_validate([
			"on" => "submit",
			"formID" => "form_add",
			"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/index/add',
			"success_response" => "#modal_global_body",
			"loading" => ['iclass-size' => 1, 'elem' => 'span']
		]) . '
</script>');
	if (isset($_POST['description'])) {
		$database->insert('personnel_time_managements', [
			"userID"=>JK_LOGINID,
			"typeID"=>$_POST['typeID'],
			"description"=>$_POST['description'],
			"datetime"=>date("Y/m/d H:i:s"),
		]);
		echo redirect_to_js('');
		exit();
	}
	\Joonika\Forms\form_create([
		"id" => 'form_add'
	]);
?>
    <div class="row">
		<?php
			echo \Joonika\Forms\field_hidden([
				"name" => "typeID",
				"value" => $_POST['typeID'],
			]);
			echo div_start('col-12');
			echo \Joonika\Forms\field_text(
				[
					"name" => "description",
					"title" => __("description"),
					"ColType" => "12,12",
				]
			);
			echo div_close();
			echo \Joonika\Forms\field_submit([
				"text" => __("save"),
				"ColType" => "12,12",
				"btn-class" => "btn btn-primary btn-lg btn-block",
				"icon" => "fa fa-save"
			]);
			\Joonika\Forms\form_end();
		?>
        <div id="action_body"></div>
    </div>
<?php
	echo $View->getFooterJsFiles();
	echo $View->footer_js;