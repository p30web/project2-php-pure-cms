<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_noteModules')) {
    error403();
    die;
}
global $View;
global $database;
if(isset($_POST['typeText']) && isset($_POST['noteSubID'])){
	$currentVal=$database->get('ipinbar_note_modules','*',[
		"id"=>$_POST['noteSubID']
	]);
	$finalVal=0;
	if($currentVal[$_POST['typeText']]==0){
		$finalVal=1;
	}
	$database->update('ipinbar_note_modules',[
		$_POST['typeText']=>$finalVal
	],[
		"id"=>$currentVal['id']
	]);
    $View->footer_js("<script>shownest();</script>");
    echo $View->footer_js;
}