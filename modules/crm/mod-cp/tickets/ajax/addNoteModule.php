<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
	error403();
	die;
}
global $database;
global $View;
if (!isset($_POST['noteModuleID']) || !isset($_POST['ticketID'])) {
	echo alertDanger();
	die;
}
new \Joonika\Modules\Crm\Crm();
$note = $database->get('crm_tickets_note_modules', '*', [
	"id" => $_POST['noteModuleID']
]);
if (!isset($note['id'])) {
	echo alertDanger();
	die;
}

\Joonika\listModulesReadFiles('mod-crm/noteType.php');
?>
    <div class="text-center text-info report-card has-bg-image"><?php
		echo langDefineGet(JK_LANG, 'crm_tickets_note_modules', 'id', $note['id']);
		?></div>
<?php
if (isset($_POST['submit'])) {
	$noteModuleID = $_POST['noteModuleID'];
	$ticketID = $_POST['ticketID'];
	$txt = $_POST['newNoteTxtModule'];

	$datetime = date("Y/m/d H:i:s");
	$database->insert('crm_tickets_notes', [
		"ticketID" => $_POST['ticketID'],
		"type" => $note['function'],
		"userID" => JK_LOGINID,
		"note" => $txt,
		"datetime" => $datetime,
	]);
	$noteID = $database->id();
	$dataUn = [];
	foreach ($_POST as $postK => $postV) {

		if (substr($postK, 0, strlen("noteModuleInput_")) === "noteModuleInput_") {
			$key = str_replace('noteModuleInput_', '', $postK);
			if (is_array($postV)) {
				foreach ($postV as $pv) {
					$database->insert('crm_tickets_notes_module_rel', [
						"ticketID" => $ticketID,
						"noteID" => $noteID,
						"noteModuleID" => $noteModuleID,
						"noteSubModuleID" => null,
						"var" => $key,
						"value" => $pv,
						"datetime" => $datetime,
					]);

				}
			} else {
				$database->insert('crm_tickets_notes_module_rel', [
					"ticketID" => $ticketID,
					"noteID" => $noteID,
					"noteModuleID" => $noteModuleID,
					"noteSubModuleID" => null,
					"var" => $key,
					"value" => $postV,
					"datetime" => $datetime,
				]);
			}
			$dataUn[$key]=$postV;

		}
	}
	if (function_exists('noteType_' . $note['function'] . '_submit')) {
		call_user_func_array('noteType_' . $note['function'] . '_submit', [["ticketID" => $ticketID,"data"=>$dataUn]]);
	}
	\Joonika\Modules\Crm\ticketNoteAttachAdd($_POST['ticketID'], $noteID, $_POST['attachmentsModule']);

	\Joonika\Modules\Crm\ticketLogAdd($_POST['ticketID'], "addNote", $noteID, null, $txt, $datetime);
	$View->footer_js('<script>
ticket_actions_notes();
//$("#modal_global").modal("hide");
</script>');
	echo $View->footer_js;
}
\Joonika\Forms\form_create([
	"id" => "addNoteModuleForm"
]);
?>
    <div class="row">
		<?php
		echo \Joonika\Forms\field_hidden([
			"name" => "ticketID",
			"value" => $_POST['ticketID'],
		]);
		echo \Joonika\Forms\field_hidden([
			"name" => "noteModuleID",
			"value" => $_POST['noteModuleID'],
		]);
		echo div_start('col-12 col-sm-12 col-md-12', 'nt_body_md');
		if (function_exists('note_module_' . $note['function'] . '_form')) {
			$var = call_user_func_array('note_module_' . $note['function'] . '_form', [["ticketID" => $_POST['ticketID'], "noteModuleID" => $_POST['noteModuleID']]]);
		}
		echo div_close();
		echo div_start('col-12 col-sm-12 col-md-12');
		echo \Joonika\Forms\field_editor([
			"name" => "newNoteTxtModule",
			"title" => __("note"),
			"type" => "simple",
			"ColType" => "12,12",
		]);
		echo '</div>';

		echo div_start('col-12');
		echo \Joonika\Upload\field_upload([
			"title" => __("attachments"),
			"name" => "attachmentsModule",
			"ColType" => '12,12',
			"thMaker" => 0,
			"maxfiles" => 20,
			"module" => "crm_tickets",
		]);
		echo '</div>';


		echo div_start('w-100', '', true);
		echo '<div class="col btn-group ">';
		echo \Joonika\Forms\field_submit([
			"text" => '<i class="fa fa-save"></i> ' . __("save"),
			"ColType" => "12,12",
			"name" => "submit",
			"value" => "save",
			"btn-class" => "btn btn-outline-success btn-labeled",
		]);
		echo '</div>';

		?>
    </div>
<?php
\Joonika\Forms\form_end();

?>
    <div class="clearfix mt-3 w-100"></div>
    <hr/>
<?php
$View->footer_js('<script>

' . ajax_validate([
		"on" => "submit",
		"formID" => "addNoteModuleForm",
		"ckeditor" => true,
		"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/addNoteModule',
		"success_response" => "#modal_global_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
    ' . ajax_load([
		"on" => "change",
		"formID" => "newNoteTxtModuleID",
		"prevent" => false,
		"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/addNoteModuleLoadFunction',
		"success_response" => "#newNoteTxtModuleName_body",
	]) . '

</script>');
echo $View->footer_js;
