<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_countries')) {
    error403();
    die;
}
if (isset($_POST['sortval'])) {
    NesatableUpdateSortData("jk_users_locations_countries",$_POST['sortval']);
}