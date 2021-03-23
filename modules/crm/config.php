<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("crm"),
    "link"=>"#",
    "name"=>"crm",
    "icon"=>"fa fa-file-signature",
    "sub"=>[
        [
            "title"=>__("contact center"),
            "link"=>"contactCenter",
            "icon"=>"fa fa-phone",
        ],[
            "title"=>__("add ticket"),
            "link"=>"addTicket",
            "icon"=>"fa fa-plus",
        ],
        [
            "title"=>__("tickets"),
            "link"=>"tickets",
            "icon"=>"fa fa-list",
        ],
        [
            "title"=>__("all tickets"),
            "link"=>"allTickets",
            "icon"=>"fa fa-list",
        ],[
            "title"=>__("tickets config"),
            "link"=>"ticketsConfig",
            "icon"=>"fa fa-cogs",
        ]
    ],
]);

global $ticketsConfig;
$ticketsConfig = [
    [
        "link" => 'settings',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-cogs",
        "title" => __("settings")
    ],[
        "link" => 'departments',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-users",
        "title" => __("departments")
    ],[
        "link" => 'parentSubjects',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("parent subject")
    ],[
        "link" => 'subjects',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("subjects")
    ],[
        "link" => 'kbArticles',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("kb articles")
    ],[
        "link" => 'origins',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-file",
        "title" => __("origins")
    ],[
        "link" => 'noteModules',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-comments",
        "title" => __("note modules")
    ]
];

global $ticketsListTabs;
$ticketsListTabs = [
    [
        "link" => 'settings',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-cogs",
        "title" => __("settings")
    ],[
        "link" => 'departments',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-users",
        "title" => __("departments")
    ],[
        "link" => 'parentSubjects',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("parent subject")
    ],[
        "link" => 'subjects',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("subjects")
    ],[
        "link" => 'kbArticles',
        "permissions" => "crm_tickets_config",
        "icon" => "fa fa-clipboard-list",
        "title" => __("kb articles")
    ]
];