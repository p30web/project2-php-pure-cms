<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
global $View;
global $database;
new \Joonika\Modules\Crm\Crm();

$global=jk_options_get('defaultContactCenterTicketGeneral');
if(!in_array($global,[1,0])){
    $global=0;
}
$title = null;
$parentSubject = null;
$subject = null;
$kbArticle = null;
$kbArticleStep = null;
$department = null;
$originVal = null;
$origin = null;
$createdBy = null;
$createdOn = null;
$closedBy = null;
$closedOn = null;
$headerClass = null;
$headerFunction = null;
$headerArgs = null;
$phone = null;
$priority = null;
$status = null;
$owner = JK_LOGINID;
$note = null;

$title .= $_POST['title'] . " + ";

if (isset($_POST['subject']) && $_POST['subject'] != "") {
    $subject = $_POST['subject'];
    if (isset($_POST['parentSubject']) && $_POST['parentSubject'] != "") {
        $parentSubject = $_POST['parentSubject'];
    }else{
        $parentSubject=\Joonika\Modules\Crm\ticketsGetParentSubject($_POST['subject']);
    }
//    $title .= \Joonika\Modules\Crm\ticketsParentSubjectTitle($parentSubject) . " + ";
//    $title .= \Joonika\Modules\Crm\ticketsSubjectTitle($_POST['subject']) . " + ";
}
$department = jk_options_get('defaultContactCenterTicketDepartment');
if (isset($_POST['department']) && $_POST['department'] != "") {
    $department=$_POST['department'];
    $title .= \Joonika\Modules\Crm\ticketDepartmentName($_POST['department']) . " + ";
}

if(isset($_POST['owner']) && $_POST['owner']!="" && $_POST['owner']!=JK_LOGINID){
    $owner=$_POST['owner'];
}
$createdBy = JK_LOGINID;
$createdOn = date("Y/m/d H:i:s");

if (isset($_POST['priority']) && $_POST['priority'] != "") {
    $priority = $_POST['priority'];
}
if (isset($_POST['newNoteTxt']) && $_POST['newNoteTxt'] != "") {
    $note = $_POST['newNoteTxt'];
}
$status = "new";
$title = rtrim($title, ' + ');


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
    if($owner!=null){
        \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, [$owner]);

    }
    if ($department != '') {
        $followers = \Joonika\Modules\Crm\ticketDepartmentFollowersUsers($department);
        \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, $followers, 'complex');
        \Joonika\Modules\Crm\ticketDepartmentChange($ticketID,$department);
    }
    \Joonika\Modules\Crm\ticketLogAdd($ticketID, 'openTicket', $ticketID, null, null, $createdOn, JK_LOGINID);

    if($note!=null){
        $noteID=\Joonika\Modules\Crm\ticketNoteAdd($ticketID,'note', $note, $createdOn,false);
        if(isset($_POST['attachments'])){
        \Joonika\Modules\Crm\ticketNoteAttachAdd($ticketID, $noteID, $_POST['attachments']);
        }
    }
    echo alertSuccess(__("ticket submitted successfully"));
    if (isset($_POST['submit']) && ($_POST['submit'] == 'saveView')) {
        $linkRedirect=JK_DOMAIN_LANG.'cp/crm/tickets/view/'.$ticketID;
    }else{
        $linkRedirect=JK_DOMAIN_LANG.'cp/crm/tickets';
    }
    echo redirect_to_js($linkRedirect,500);
    echo $View->footer_js;
} else {
    echo alertDanger(__("an error occurred"));
}