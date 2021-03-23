<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_introductionMethods')) {
    error403();
    die;
}
if (isset($_POST['sortval'])) {
    NesatableUpdateSortData("ipinbar_introduction_methods",$_POST['sortval']);
}