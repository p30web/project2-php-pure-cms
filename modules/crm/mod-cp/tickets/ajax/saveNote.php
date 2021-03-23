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
if (isset($_POST['newNoteTxt']) && isset($_POST['ticketID'])) {
    $note = \Joonika\Modules\Crm\ticketNoteAdd($_POST['ticketID'],'note', $_POST['newNoteTxt']);
    if ($note >= 1) {
        \Joonika\Modules\Crm\ticketNoteAttachAdd($_POST['ticketID'], $note, $_POST['attachments']);
    }
    echo redirect_to_js();
}
echo $View->footer_js;