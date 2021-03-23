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

$global = jk_options_get('defaultContactCenterTicketGeneral');
if (!in_array($global, [1, 0])) {
    $global = 0;
}
$title = null;
$parentSubject = null;
$subject = null;
$department = null;
$createdBy = null;
$createdOn = null;
$closedBy = null;
$closedOn = null;
$phone = null;
$priority = null;
$status = null;
$owner = null;
$note = null;
//print_r($_POST);

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
if (isset($_POST['title']) && $_POST['title'] != "") {
    $title .= $_POST['title'] . " + ";
}
$department = jk_options_get('defaultContactCenterTicketDepartment');
if (isset($_POST['department']) && $_POST['department'] != "") {
    $department=$_POST['department'];
//    $title .= \Joonika\Modules\Crm\ticketDepartmentName($department) . " + ";
    $department = $_POST['department'];
    if (isset($_POST['submit']) && $_POST['submit'] == "saveClose") {
        $defaultDep = jk_options_get('defaultContactCenterTicketDepartment');
        if ($defaultDep != $department) {
            echo alertWarning(__("if you select department you can't close ticket"));
            die;
        }
    }
}
if(isset($_POST['owner']) && $_POST['owner']!="" && $_POST['owner']!=JK_LOGINID){
    $owner=$_POST['owner'];
}
$origin = null;
$originValue = null;
if (isset($_POST['origin']) && $_POST['origin'] != "") {
    $origin = $_POST['origin'];
}
if (isset($_POST['originValue']) && $_POST['originValue'] != "") {
    $originValue = $_POST['originValue'];
    $title .= $originValue . " + ";
}

$createdBy = JK_LOGINID;
$createdOn = date("Y/m/d H:i:s");

if (isset($_POST['phone']) && $_POST['phone'] != "") {
    $phone = $_POST['phone'];
}
if (isset($_POST['priority']) && $_POST['priority'] != "") {
    $priority = $_POST['priority'];
}
if (isset($_POST['newNoteTxt']) && $_POST['newNoteTxt'] != "") {
    $note = $_POST['newNoteTxt'];
}
$status = "new";

$title = trim($title);
$title = rtrim($title, "+");
$title = trim($title);


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

    if ($origin != "" && $originValue != "") {
        \Joonika\Modules\Crm\ticketAddOrigin($ticketID, $origin,$originValue);
    }
    \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, [JK_LOGINID]);
    if ($department != '') {
        $followers = \Joonika\Modules\Crm\ticketDepartmentFollowersUsers($department);
        \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID, $followers, 'complex');
        \Joonika\Modules\Crm\ticketDepartmentChange($ticketID,$department);
    }
    \Joonika\Modules\Crm\ticketLogAdd($ticketID, 'openTicket', $ticketID, null, null, $createdOn, JK_LOGINID);
    if (isset($_POST['submit']) && ($_POST['submit'] == 'saveClose')) {
        $owner = JK_LOGINID;
        $status = "closed";
        \Joonika\Modules\Crm\ticketOwn($ticketID, $owner, $createdOn);
        $database->update("crm_tickets", [
            "closedBy" => JK_LOGINID,
            "closedOn" => $createdOn,
        ], [
            "id" => $ticketID
        ]);
        \Joonika\Modules\Crm\ticketChangeStatus($ticketID, $status, $createdOn);
    }
    if ($note != "" || $note != null) {
        \Joonika\Modules\Crm\ticketNoteAdd($ticketID, 'note',$note, $createdOn, false);
    }
	if (isset($_POST['submit']) && $_POST['submit'] == "saveView") {
		echo alertSuccess(__("please wait"));
		echo redirect_to_js(JK_DOMAIN_LANG."cp/crm/tickets/view/".$ticketID);
	}else {
		$View->footer_js('<script>
$("#datatable_list").DataTable().ajax.reload(null, false);
$("#modal_global").modal("hide");
</script>');
	}
    echo $View->footer_js;
} else {
    echo alertDanger(__("an error occurred"));
}