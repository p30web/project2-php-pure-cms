<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
   "title"=>__("system management"),
   "link"=>"#",
   "name"=>"main",
   "icon"=>"fa fa-globe",
   "sub"=>[
       [
           "title"=>__("site setting"),
           "link"=>"siteSetting",
           "icon"=>"fa fa-cogs",
       ],
       [
           "title"=>__("template setting"),
           "link"=>"templateSetting",
           "icon"=>"fab fa-affiliatetheme",
       ],[
           "title"=>__("translate"),
           "link"=>"translate",
           "icon"=>"fa fa-language",
       ],[
           "title"=>__("mail config"),
           "link"=>"mailConfig",
           "icon"=>"fa fa-envelope-square",
       ],[
           "title"=>__("database"),
           "link"=>"database",
           "icon"=>"fa fa-database",
       ],[
           "title"=>__("update"),
           "link"=>"update",
           "icon"=>"fa fa-sync",
       ],[
           "title"=>__("image optimization"),
           "link"=>"imageOptimization",
           "icon"=>"fa fa-image",
       ],[
           "title"=>__("dashboard widgets"),
           "link"=>"dashboardWidgets",
           "icon"=>"fa fa-image",
       ]
   ],
]);