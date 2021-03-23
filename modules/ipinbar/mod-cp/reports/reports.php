<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('reports_ipinbar')) {
		error403();
		die;
	}
	global $reports;
	array_push($reports, [
		"name" => "ipinbar",
		"title" => __("ipin"),
		"permission" => "reports_ipin",
		"sub"=>[
            [
                "icon"=>"fa fa-truck-moving",
                "name"=>"transit",
                "title" => __("transit favorite"),
                "permission" => "reports_ipinbar_transit",
            ],[
                "icon"=>"fa fa-truck",
                "name"=>"province",
                "title" => __("road favorite"),
                "permission" => "reports_ipinbar_road",
            ],[
                "icon"=>"fa fa-star",
                "name"=>"introductionMethods",
                "title" => __("introduction methods"),
                "permission" => "reports_ipinbar_introductionMethods",
            ]
		]
	]);