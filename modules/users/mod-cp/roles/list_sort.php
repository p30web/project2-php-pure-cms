<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_roles')) {
    error403();
    die;
}
if (isset($_POST['sortval'])) {
    NesatableUpdateSortData("jk_roles",$_POST['sortval']);
}