<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('reports_crm')) {
		error403();
		die;
	}
	global $reports;
	array_push($reports, [
		"name" => "crm",
		"title" => __("crm"),
		"permission" => "reports_crm",
		"sub"=>[
			[
				"name"=>"ticketsCount",
				"icon"=>"fa fa-chart-bar",
				"title" => __("tickets count"),
				"permission" => "reports_crm_ticketsCount",
			],
			[
                "icon"=>"fa fa-list-ol",
                "name"=>"ticketsSubjects",
				"title" => __("tickets subjects"),
				"permission" => "reports_crm_ticketsSubjects",
			],
		]
	]);