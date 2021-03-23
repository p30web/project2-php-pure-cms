<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_noteModules')) {
	error403();
	die;
}
$exra_float = [];
$countryID = 0;
global $Route;
if (isset($Route->path[4])) {
	$countryID = $Route->path[4];
} else {
	$countryID = 0;
}
global $database;
global $extra_float;
$extra_float = [];
$getdatas = $database->select('ipinbar_note_modules', '*', [
	'status' => "active"
]);
if (sizeof($getdatas) >= 1) {
	foreach ($getdatas as $getdata) {
		if ($getdata['needBlock'] == 1) {
			$needBlockClass = "btn-danger";
			$needBlockValue = __("yes");
		} else {
			$needBlockClass = "btn-outline-danger";
			$needBlockValue = __("no");
		}
		if ($getdata['reDial'] == 1) {
			$reDialClass = "btn-success";
			$reDialValue = __("yes");
		} else {
			$reDialClass = "btn-outline-success";
			$reDialValue = __("no");

		}
		$extra_float[$getdata['id']] = '<button type="button" onclick="changeValModule(\'needBlock\','.$getdata['id'].')" class="btn btn-sm ' . $needBlockClass . '">' . __("block user").' : '.$needBlockValue . '</button>';
		$extra_float[$getdata['id']] .= '<button type="button" onclick="changeValModule(\'reDial\','.$getdata['id'].')" class="btn btn-sm ' . $reDialClass . '">' .__("re dial").' : '. $reDialValue . '</button>';
	}
}
NestableTableJS("ipinbar_note_modules", JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/noteModules/list_sort', 2, 1);
NestableTableGetData('ipinbar_note_modules', 'ipinbar_note_modules', JK_LANG, 0, $extra_float, $countryID);
global $View;
echo $View->footer_js;