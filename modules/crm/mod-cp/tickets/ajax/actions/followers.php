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
    global $database;
    $followers = $database->select('crm_tickets_followers', '*', [
        "AND" => [
            "ticketID" => $_POST['ticketID'],
            "status" => "active",
            "hidden" => "0",
        ]
    ]);
    if (sizeof($followers) >= 1) {
        $ticketSt=$database->get('crm_tickets','status',[
                "id"=>$_POST['ticketID']
        ]);

        foreach ($followers as $follower) {
            ?>
            <div class="col-12 border-bottom">
                <div class="float-left btn-group">
                    <button class="btn btn-sm btn-info" onclick="emailFollower(<?php echo $follower['id']; ?>)"><i class="fa fa-envelope"></i>
                    </button>
                    <?php
                    if ($ticketSt!='closed' && $ACL->hasPermission('crm_tickets_follower_remove')) {
                        ?>
                        <button class="btn btn-sm btn-danger"
                                onclick="removeFollower(<?php echo $follower['id']; ?>)"><i
                                class="fa fa-times"></i>
                        </button>
                        <?php
                    }
                    ?>
                    <?php
                    if ($follower['read'] == 0) {
                        $cirF = "far fa-circle text-grey";
                        $cirFT = __("unread");
                    } elseif ($follower['read'] == 2) {
                        $cirF = "fa fa-circle text-warning";
                        $cirFT = __("unread last changes");
                    } else {
                        $cirF = "fa fa-circle text-success";
                        $cirFT = __("read by");
                    }
                    ?>
                    <i class="<?php echo $cirF; ?> pt-2 pr-2 pl-2" data-popup="tooltip"
                       data-title="<?php echo $cirFT ?>"></i>
                </div>
                <?php
                echo nickName($follower['userID'])
                ?>
            </div>
            <?php
        }
        $View->footer_js('<script>$(\'[data-popup="tooltip"]\').tooltip();</script>');
        echo $View->footer_js;
    }
}