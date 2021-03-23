<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
   "title"=>__("blog"),
   "link"=>"#",
   "name"=>"blog",
   "icon"=>"fa fa-file-signature",
   "sub"=>[
       [
           "title"=>__("posts list"),
           "link"=>"list",
           "name"=>"list",
           "icon"=>"fa fa-list",
       ],
       [
           "title"=>__("add"),
           "link"=>"list/edit",
           "name"=>"edit",
           "icon"=>"fa fa-plus",
       ],[
           "title"=>__("categories"),
           "link"=>"categories",
           "icon"=>"fa fa-layer-group",
       ],[
           "title"=>__("pages list"),
           "link"=>"pages",
           "name"=>"pages",
           "icon"=>"fa fa-list",
       ]
   ],
]);