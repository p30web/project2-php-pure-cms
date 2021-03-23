<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('smsir_list')) {
    error403();
    die;
}
if(isset($_POST['changeID'])){
	global $database;
	$get=$database->get('smsir_temps',"status",[
		"id"=>$_POST['changeID']
	]);
	if($get=="active"){
		$newGet="inactive";
	}else{
		$newGet="active";
	}
	$database->update('smsir_temps',[
		"status"=>$newGet
	],[
		"id"=>$_POST['changeID']
	]);
	echo redirect_to_js();
}