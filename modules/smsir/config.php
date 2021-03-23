<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>"sms.ir",
    "link"=>"#",
    "name"=>"smsir",
    "icon"=>"fa fa-comments",
    "sub"=>[
        [
            "title"=>__("sms lists"),
            "link"=>"list",
            "name"=>"list",
            "icon"=>"fa fa-list",
        ],[
            "title"=>__("send sms"),
            "link"=>"sendSms",
            "name"=>"sendSms",
            "icon"=>"fa fa-comments",
        ],
        [
            "title"=>__("config"),
            "link"=>"config",
            "name"=>"config",
            "icon"=>"fa fa-cogs",
        ],
    ],
]);