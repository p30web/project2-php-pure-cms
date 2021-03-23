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
if(isset($_POST['ticketID'])){
    new \Joonika\Modules\Crm\Crm();
    global $database;
    $histories = $database->select('crm_tickets_logs', 'id', [
        "AND" => [
            "ticketID" => $_POST['ticketID'],
            "status" => "active",
            "type[!]" => "addNote",
        ]
    ]);
    if (sizeof($histories) >= 1) {
        foreach ($histories as $history) {
            ?>
            <div class="col-12 small pb-1 border-bottom">
                <?php
                echo \Joonika\Modules\Crm\ticketHistoryShow($history);
                ?>
            </div>
            <?php
        }
        $View->footer_js('<script>$(\'[data-popup="tooltip"]\').tooltip();</script>');
        echo $View->footer_js;
    }
}