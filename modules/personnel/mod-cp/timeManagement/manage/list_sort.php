<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement_manage')) {
    error403();
    die;
}
if (isset($_POST['sortval'])) {
    NesatableUpdateSortData("personnel_time_management_types",$_POST['sortval']);
}