<?php
if (!defined('jk')) die('Access Not Allowed !');
global $database;
$from = null;
$to = null;
$text = null;
if(isset($_GET['to'])){
    $to=\Joonika\Idate\tr_num($_GET['to']);
}
if(isset($_GET['from'])){
    $from='0'.\Joonika\Idate\tr_num($_GET['from']);
}
if(isset($_GET['text'])){
    $text=$_GET['text'];
}
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$database->insert('smsir_receives', [
    "text"=>$text,
    "from"=>$from,
    "to"=>$to,
    "datetime"=>date("Y/m/d H:i:s"),
    "ip"=>$ip,
]);


new \Joonika\Modules\Crm\Crm();
$global = 1;
$title = __("receive sms") . " + " . $from . ' + '. $to . ' + ';
$parentSubject = null;
$subject = null;
$kbArticle = null;
$kbArticleStep = null;
$department = jk_options_get('smsReceiveTicketDepartment');
$originVal = null;
$origin = null;
$createdBy = 1;
$createdOn = date("Y/m/d H:i:s");
$closedBy = null;
$closedOn = null;
$headerClass = null;
$headerFunction = null;
$headerArgs = null;
$phone = $from;
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
echo $ticketID;
if ($ticketID >= 1) {
    \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, [1]);
    \Joonika\Modules\Crm\ticketLogAdd($ticketID, 'openTicket', $ticketID, null, null, $createdOn, 1);
    \Joonika\Modules\Crm\ticketAddOrigin($ticketID, "ContactCenter",$from);
    if ($department != '') {
        $followers = \Joonika\Modules\Crm\ticketDepartmentFollowersUsers($department);
        \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, $followers, 'complex');
        \Joonika\Modules\Crm\ticketDepartmentChange($ticketID,$department);
    }
    \Joonika\Modules\Crm\ticketNoteAdd($ticketID,'note',$text);
} else {
    echo alertDanger(__("an error occurred"));
}













