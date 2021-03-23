<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
if(isset($_POST)){
    if(isset($_POST['defaultContactCenterTicketDepartment'])) {
        jk_options_set('defaultContactCenterTicketDepartment',$_POST['defaultContactCenterTicketDepartment']);
    }
    if(isset($_POST['defaultContactCenterTicketGeneral'])) {
        jk_options_set('defaultContactCenterTicketGeneral',$_POST['defaultContactCenterTicketGeneral']);
    }
    echo alert([
        "type"=>"success",
        "text"=>__("saved"),
    ]);

}