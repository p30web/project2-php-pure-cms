<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("faq"),
    "link"=>"#",
    "name"=>"faq",
    "icon"=>"fa fa-question-circle",
    "sub"=>[
        [
            "title"=>__("questions"),
            "link"=>"list",
            "name"=>"list",
            "icon"=>"fa fa-list",
        ]
    ],
]);