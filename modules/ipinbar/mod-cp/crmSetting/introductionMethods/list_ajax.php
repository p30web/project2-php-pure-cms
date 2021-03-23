<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_introductionMethods')) {
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
$getdatas = $database->select('ipinbar_introduction_methods', '*', [
	'status' => "active"
]);
if (sizeof($getdatas) >= 1) {
	foreach ($getdatas as $getdata) {
//		$extra_float[$getdata['id']] = '<button type="button" onclick="changeValModule(\'needBlock\','.$getdata['id'].')" class="btn btn-sm ' . $needBlockClass . '">' . __("block user").' : '.$needBlockValue . '</button>';
//		$extra_float[$getdata['id']] .= '<button type="button" onclick="changeValModule(\'reDial\','.$getdata['id'].')" class="btn btn-sm ' . $reDialClass . '">' .__("re dial").' : '. $reDialValue . '</button>';
	}
}
NestableTableJS("ipinbar_introduction_methods", JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/noteModules/list_sort', 2, 1);
NestableTableGetData('ipinbar_introduction_methods', 'ipinbar_introduction_methods', JK_LANG, 0, $extra_float, $countryID);
global $View;
echo $View->footer_js;