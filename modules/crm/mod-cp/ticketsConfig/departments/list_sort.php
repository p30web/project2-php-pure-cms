<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
if (isset($_POST['sortval'])) {
    NesatableUpdateSortData("crm_tickets_departments",$_POST['sortval']);
}