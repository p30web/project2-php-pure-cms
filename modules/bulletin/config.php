<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("bulletin"),
    "link"=>"#",
    "name"=>"bulletin",
    "icon"=>"fa fa-question-circle",
    "sub"=>[
        [
            "title"=>__("insert Announce"),
            "link"=>"announceInsert/index",
            "name"=>"announceAnnounce",
            "icon"=>"fa fa-plus",
        ],[
            "title"=>__("announce list"),
            "link"=>"announcelist/index",
            "name"=>"listAnnounce",
            "icon"=>"fa fa-list",
        ],[
            "title"=>__("announce edit"),
            "link"=>"announceEdit/index",
            "name"=>"editAnnounce",
            "icon"=>"fa fa-edit",
        ]
    ],
]);