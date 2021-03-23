<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>__("reports"),
    "link"=>JK_DOMAIN_LANG."cp/reports/index",
    "name"=>"reports",
    "icon"=>"fa fa-chart-bar",
]);