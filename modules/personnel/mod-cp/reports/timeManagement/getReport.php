<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_crm_ticketsCount')) {
    error403();
    die;
}
if (!isset($_POST['from_date']) || !isset($_POST['to_date']) || $_POST['from_date'] == "" || $_POST['to_date'] == "") {
    echo alertDanger(__("date not valid"));
} else {
    global $database;
    $report = new \Joonika\Modules\Reports\Reports();
    $from_date = \Joonika\Idate\datetodate($_POST['from_date'], 3, "0", 6, 'en');
    $to_date = \Joonika\Idate\datetodate($_POST['to_date'], 3, "0", "Y/m/d 23:59:59", 'en');
    echo alertInfo();
}