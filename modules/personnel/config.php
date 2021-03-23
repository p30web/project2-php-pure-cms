<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $Cp;
	global $Route;
	$Cp->addSidebar([
		"title" => __("personnel"),
		"link" => "#",
		"name" => "personnel",
		"icon" => "fa fa-user",
		"sub" => [
			[
				"title" => __("my information"),
				"link" => "profile",
				"icon" => "fa fa-eye",
			], [
				"title" => __("organization chart"),
				"link" => "orgChart",
				"icon" => "fa fa-tree",
			], [
				"title" => __("personnel information"),
				"link" => "information",
				"icon" => "fa fa-users",
			], [
				"title" => __("attendance and traffic"),
				"link" => "attendance",
				"icon" => "fa fa-traffic-light",
			], [
				"title" => __("time management"),
				"link" => "timeManagement/index",
				"name" => "timeManagement",
				"icon" => "fa fa-clock",
			], [
				"title" => __("config"),
				"link" => "config",
				"icon" => "fa fa-cogs",
			]
		],
	]);
	global $personnelConfigTabs;
	$personnelConfigTabs = [
		[
			"link" => 'educationalFieldsCat',
			"permissions" => "personnel_config_educational_fields",
			"icon" => "fa fa-map",
			"title" => __("educational fields cat")
		], [
			"link" => 'educationalFields',
			"permissions" => "personnel_config_educational_fields",
			"icon" => "fa fa-map",
			"title" => __("educational fields")
		]
	];
	global $attendanceTabs;
	$attendanceTabs = [
		[
			"link" => 'periods',
			"permissions" => "personnel_attendance_periods",
			"icon" => "fa fa-user-clock",
			"title" => __("periods")
		], [
			"link" => 'periodsDefine',
			"permissions" => "personnel_attendance_periodsDefine",
			"icon" => "fa fa-th",
			"title" => __("define period")
		]
	];
	global $timeManagementTabs;
	$timeManagementTabs = [
		[
			"link" => 'index',
			"permissions" => "personnel_timeManagement",
			"icon" => "fa fa-user-clock",
			"title" => __("index")
		], [
			"link" => 'manage',
			"permissions" => "personnel_timeManagement_manage",
			"icon" => "fa fa-th",
			"title" => __("manage")
		], [
			"link" => 'wallboard',
			"permissions" => "personnel_timeManagement_wallboard",
			"icon" => "fa fa-th",
			"title" => __("wallboard")
		]
	];
	global $lnkProfileLinks;
	if (isset($Route->path[0]) && $Route->path[0] == 'personnel' && isset($Route->path[2]) && is_numeric($Route->path[2])) {
		$userID = $Route->path[2];
		$lnkProfileLinks = [
			"info" => JK_DOMAIN_LANG . 'cp/personnel/profile/' . $userID,
			"update" => JK_DOMAIN_LANG . 'cp/personnel/profileEdit/' . $userID,
			"checkActive" => 3,
		];
	} else {
		$userID = JK_LOGINID;
		$lnkProfileLinks = [
			"info" => JK_DOMAIN_LANG . 'cp/personnel/profile',
			"update" => JK_DOMAIN_LANG . 'cp/personnel/profileEdit',
			"checkActive" => 2,
		];
	}