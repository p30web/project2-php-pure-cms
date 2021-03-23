<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}

if(isset($_POST['subject'])){
    global $View;
    new \Joonika\Modules\Crm\Crm();
$ValdID=\Joonika\Modules\Crm\ticketsGetParentSubject($_POST['subject']);

if($ValdID>=1){
    $js='<script>
$(\'#parentSubject\').removeAttr("required");</script>';
}else{
    $js='<script>
$(\'#parentSubject\').attr(\'required\',\'required\');</script>';
}

    echo $js;
}