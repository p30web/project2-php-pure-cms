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
    if (isset($_POST['forwardIdUser'])) {
        if($_POST['forwardIdUser']!=JK_LOGINID){
            \Joonika\Modules\Crm\ticketDepartmentFollowersAddToTicket($ticketID,[$_POST['forwardIdUser']]);
        \Joonika\Modules\Crm\ticketOwn($ticketID,$_POST['forwardIdUser']);
        $View->footer_js('<script>$("#modal_global").modal("hide");ticket_actions_btns();</script>');
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'open');
        }else{
            echo alertWarning(__("you can't forward ticket to your self"));
        }
    }
        echo \Joonika\Forms\form_create([
            'id' => "forwardTicketForm"
        ]);
        echo \Joonika\Forms\field_hidden([
            "name" => "ticketID",
            "value" => $ticketID,
        ]);
        echo '<div class="col-12">';
        $users = \Joonika\Modules\Users\usersArray();
        echo \Joonika\Forms\field_select(
            [
                "name" => "forwardIdUser",
                "title" => __("user"),
                "first" => true,
                "required" => true,
                "array" => $users,
                "ColType" => "12,12",
            ]
        );
        echo '</div>';
        echo \Joonika\Forms\field_submit(
            [
                "text" => __("assign"),
                "ColType" => "12,12",
                "btn-class" => "btn btn-primary btn-lg btn-block",
                "icon" => "fa fa-save"
            ]
        );
        echo \Joonika\Forms\form_end();

        $View->footer_js('<script>
' . ajax_validate([
                "on" => "submit",
                "formID" => "forwardTicketForm",
                "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/forward',
                "success_response" => "#modal_global_body",
                "loading" => ['iclass-size' => 1, 'elem' => 'span']
            ]) . '
</script>');

    echo $View->footer_js;
}