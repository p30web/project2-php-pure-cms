<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("Aparat"),
    "link"=> "#",
    "name"=>"aparat",
    "icon"=>"fa fa-chart-bar",
    "sub"=>[
        [
            "title"=>__("Last Vidio"),
            "link"=>"last",
            "name"=>"last",
            "icon"=>"fa fa-bars",
        ],
        [
            "title"=>__("mostviewedvideos"),
            "link"=>"index",
            "name"=>"index",
            "icon"=>"fa fa-list",
        ], [
            "title"=>__("Category"),
            "link"=>"cat",
            "name"=>"cat",
            "icon"=>"fa fa-plus",
        ], [
            "title"=>__("Chanel"),
            "link"=>"chanel",
            "name"=>"chanel",
            "icon"=>"fa fa-user",
        ]
    ],
]);

