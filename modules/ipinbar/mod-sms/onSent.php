<?php
if (isset($_POST['smsID'])) {
    if (!defined('jk')) die('Access Not Allowed !');

    global $database;
    global $View;
    $sms = $database->get('smsir_temps', "*", [
        "id" => $_POST['smsID']
    ]);
    if(!isset($_POST['ticketID']) ||  $_POST['ticketID']==""){
    new \Joonika\Modules\Crm\Crm();

    $global = 1;
    $title = __("sending sms") . " + " . $_POST['number'] . ' + ' . langDefineGet(JK_LANG, 'smsir_temps', 'id', $sms['id']);
    $parentSubject = null;
    $subject = null;
    $kbArticle = null;
    $kbArticleStep = null;
    $department = jk_options_get('defaultContactCenterTicketDepartment');
    $originVal = null;
    $origin = null;
    $createdBy = JK_LOGINID;
    $createdOn = date("Y/m/d H:i:s");
    $closedBy = JK_LOGINID;
    $closedOn = $createdOn;
    $headerClass = null;
    $headerFunction = null;
    $headerArgs = null;
    $phone = $_POST['number'];
    $priority = "low";
    $owner = JK_LOGINID;
    $status = "new";

    $database->insert('crm_tickets', [
        "global" => $global,
        "title" => $title,
        "parentSubject" => $parentSubject,
        "subject" => $subject,
        "department" => $department,
        "createdBy" => $createdBy,
        "createdOn" => $createdOn,
        "closedBy" => $closedBy,
        "closedOn" => $closedOn,
        "phone" => $phone,
        "priority" => $priority,
        "status" => $status,
        "owner" => $owner,
    ]);
    $ticketID = $database->id();
    if ($ticketID >= 1) {
        \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, [JK_LOGINID]);
        \Joonika\Modules\Crm\ticketLogAdd($ticketID, 'openTicket', $ticketID, null, null, $createdOn, JK_LOGINID);
        \Joonika\Modules\Crm\ticketAddOrigin($ticketID, "ContactCenter",$_POST['number']);
        if ($department != '') {
            $followers = \Joonika\Modules\Crm\ticketDepartmentFollowersUsers($department);
            \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, $followers, 'complex');
            \Joonika\Modules\Crm\ticketDepartmentChange($ticketID,$department);
        }
        \Joonika\Modules\Crm\ticketNoteAdd($ticketID,'module_smsIRSent',"smsID=".$sms['id']."&number=".$_POST['number']);
        \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'closed');
        echo alertSuccess(__("ticket submitted successfully"));
        die;
    } else {
        echo alertDanger(__("an error occurred"));
    }
    }else{
        \Joonika\Modules\Crm\ticketNoteAdd($_POST['ticketID'],'module_smsIRSent',$_POST['number']);
    }
}