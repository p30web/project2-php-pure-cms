<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("users"),
    "link"=>"#",
    "name"=>"users",
    "icon"=>"fa fa-users",
    "sub"=>[
        [
            "title"=>__("users list"),
            "link"=>"usersList",
            "icon"=>"fa fa-cogs",
        ],
        [
            "title"=>__("groups"),
            "link"=>"groups",
            "icon"=>"fab fa-affiliatetheme",
        ],[
            "title"=>__("roles"),
            "link"=>"roles",
            "icon"=>"fa fa-language",
        ],[
            "title"=>__("permissions"),
            "link"=>"permissions/index",
            "name"=>"permissions",
            "icon"=>"fa fa-database",
        ],[
            "title"=>__("displacements"),
            "link"=>"displacements/index",
            "name"=>"displacements",
            "icon"=>"fa fa-sync",
        ],[
            "title"=>__("locations"),
            "link"=>"locations/countries",
            "name"=>"locations",
            "icon"=>"fa fa-map",
        ],[
            "title"=>__("confirms"),
            "link"=>"confirms",
            "name"=>"confirms",
            "icon"=>"fa fa-crosshairs",
        ],[
            "title"=>__("announce Insert"),
            "link"=>"announceInsert",
            "name"=>"announceInsert",
            "icon"=>"fa fa-cogs ",
        ],[
            "title"=>__("announce list"),
            "link"=>"announceList",
            "name"=>"announceList",
            "icon"=>"fa fa-cogs ",
        ]
    ],
]);
global $permission_tabs;
$permission_tabs = [
    [
        "link" => 'index',
        "permissions" => "users_permissions_index",
        "icon" => "fa fa-key",
        "title" => __("permission by key")
    ], [
        "link" => 'user',
        "permissions" => "users_permissions_user",
        "icon" => "fa fa-user",
        "title" => __("permission by user")
    ], [
        "link" => 'group',
        "permissions" => "users_permissions_group",
        "icon" => "fa fa-users",
        "title" => __("permission by group")
    ]
];

global $displacement_tabs;
$displacement_tabs = [
    [
        "link" => 'index',
        "permissions" => "users_displacement_index",
        "icon" => "fa fa-tachometer-alt",
        "title" => __("index")
    ], [
        "link" => 'type',
        "permissions" => "users_displacement_type",
        "icon" => "fa fa-exchange-alt",
        "title" => __("type")
    ], [
        "link" => 'defaults',
        "permissions" => "users_displacement_defaults",
        "icon" => "fa fa-users-cog",
        "title" => __("default config")
    ]
];
global $locations_tabs;
$locations_tabs = [
    [
        "link" => 'countries',
        "permissions" => "users_locations_countries",
        "icon" => "fa fa-map",
        "title" => __("countries")
    ], [
        "link" => 'provinces',
        "permissions" => "users_locations_provinces",
        "icon" => "fa fa-map",
        "title" => __("provinces")
    ], [
        "link" => 'cities',
        "permissions" => "users_locations_cities",
        "icon" => "fa fa-map",
        "title" => __("cities")
    ]
];