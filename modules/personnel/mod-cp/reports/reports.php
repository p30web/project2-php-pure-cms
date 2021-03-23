<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('reports_personnel')) {
		error403();
		die;
	}
	global $reports;
	array_push($reports, [
		"name" => "personnel",
		"title" => __("personnel"),
		"permission" => "reports_personnel",
		"sub"=>[
			[
				"name"=>"timeManagement",
				"icon"=>"fa fa-clock",
				"title" => __("time management report"),
				"permission" => "reports_crm_timeManagement",
			]
		]
	]);