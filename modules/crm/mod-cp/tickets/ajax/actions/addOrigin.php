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
    if (isset($_POST['origin'])) {
        $has=$database->get('crm_tickets_origins','*',[
            "AND"=>[
                "ticketID"=>$_POST['ticketID'],
                "origin"=>$_POST['origin'],
                "originValue"=>$_POST['originValue'],
            ]
        ]);
        if(isset($has['id'])){
            $View->footer_js('<script>
swal(
  \''.__("origin problem").'\',
  \''.__("origin is duplicate").'\',
  \'warning\'
)
</script>');
        }else{
            $database->insert('crm_tickets_origins',[
                "ticketID"=>$_POST['ticketID'],
                "origin"=>$_POST['origin'],
                "originValue"=>$_POST['originValue'],
            ]);
            $originID=$database->id();
            \Joonika\Modules\Crm\ticketLogAdd($_POST['ticketID'], "addOrigin",$originID,$_POST['origin'],$_POST['originValue']);
        }

        $View->footer_js('<script>$("#modal_global").modal("hide");ticket_actions_origins();</script>');
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID, 'open');

    }
    echo \Joonika\Forms\form_create([
        'id' => "OriginTicketForm"
    ]);
    echo \Joonika\Forms\field_hidden([
        "name" => "ticketID",
        "value" => $ticketID,
    ]);
    echo '<div class="col-12">';
    $originsTitle = \Joonika\Modules\Crm\ticketOriginsTitle();
    echo \Joonika\Forms\field_select(
        [
            "name" => "origin",
            "title" => __("origin"),
            "first" => true,
            "required" => true,
            "array" => $originsTitle,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo '<div class="col-12">';
    echo \Joonika\Forms\field_text(
        [
            "name" => "originValue",
            "title" => __("origin value"),
            "required" => true,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo \Joonika\Forms\field_submit(
        [
            "text" => __("add"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]
    );
    echo \Joonika\Forms\form_end();

    $View->footer_js('<script>
' . ajax_validate([
            "on" => "submit",
            "formID" => "OriginTicketForm",
            "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/addOrigin',
            "success_response" => "#modal_global_body",
            "loading" => ['iclass-size' => 1, 'elem' => 'span']
        ]) . '
</script>');

    echo $View->footer_js;
}