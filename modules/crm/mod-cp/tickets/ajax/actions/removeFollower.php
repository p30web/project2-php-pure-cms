<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
$continue = true;
if (!isset($_POST['ticketID'])) {
    $continue = false;
}
if ($continue) {
    global $database;
    $ticket = $database->get('crm_tickets', '*', [
        "id" => $_POST['ticketID']
    ]);
    if (!isset($ticket['id'])) {
        $continue = false;
    } else {
        $ticketID = $ticket['id'];
    }
}

if ($continue) {
    new \Joonika\Modules\Crm\Crm();

    if (isset($_POST['remid'])) {
        $dataget=$database->get('crm_tickets_followers','*',[
            "id"=>$_POST['remid']
        ]);
        if(isset($dataget['id']) && $dataget['userID']!=JK_LOGINID){
            $database->update('crm_tickets_followers', [
                "status" => "removed",
            ],[
                "id"=>$dataget['id']
            ]);
            \Joonika\Modules\Crm\ticketLogAdd($ticketID, 'removeFollower', $dataget['id'],$dataget['userID']);
        }
        $View->footer_js('<script>$("#modal_global").modal("hide");ticket_actions_followers();ticket_actions_histories();</script>');
    }
}