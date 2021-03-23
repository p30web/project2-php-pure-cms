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
if (isset($_POST['ticketID'])) {
    new \Joonika\Modules\Crm\Crm();
    global $database;

    if (isset($_POST['remid'])) {
        $database->update('crm_tickets_origins', [
            "status" => "removed"
        ], [
            "id" => $_POST['remid']
        ]);
        \Joonika\Modules\Crm\ticketLogAdd($_POST['ticketID'], 'removeOrigin', $_POST['remid']);
    }

    $origins = \Joonika\Modules\Crm\ticketOrigins($_POST['ticketID']);
    if (sizeof($origins) >= 1) {
        $ticketSt = $database->get('crm_tickets', "status", [
            "id" => $_POST['ticketID']
        ]);
        ?>
        <div class="card card-body">
            <div class="row small text-center table-responsive">
                <table class="table table-sm ">
                    <?php
                    foreach ($origins as $originID => $origin) {
                        ?>
                        <tr>
                            <td><?php echo $origin['name']; ?></td>
                            <td><?php echo $origin['value']; ?></td>
                            <?php
                            if ($ticketSt != "closed" && $ACL->hasPermission('crm_tickets_origin_remove')) {
                                ?>
                                <td><i onclick="rmOrigin(<?php echo $originID; ?>)" class="fa fa-times text-danger"></i>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
}