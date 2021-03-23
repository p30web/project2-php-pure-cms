<?php
if(!defined('jk')) die('Access Not Allowed !');
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
$continue=true;
if(!isset($_POST['ticketID'])){
    $continue=false;
}
if($continue){
    global $database;
    $ticket=$database->get('crm_tickets','*',[
        "id"=>$_POST['ticketID']
    ]);
    if(!isset($ticket['id'])){
        $continue=false;
    }else{
        $ticketID=$ticket['id'];
    }
}
if($continue){
    $notes = $database->select('crm_tickets_notes', '*', [
        "AND" => [
            "ticketID" => $ticketID,
            "status" => 'active',
        ]
    ]);
    if (sizeof($notes) >= 1) {
        \Joonika\listModulesReadFiles('mod-crm/noteType.php');
        foreach ($notes as $note) {
            $profileImage = \Joonika\Modules\Users\profileImage($note['userID']);
            ?>
            <div class="card mb-2">
                <div class="card-body p-0">
                    <div class="media   mb-0 ">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-2 text-center p-0">
                                    <img src="<?php echo $profileImage; ?>"
                                         class="d-none img rounded-circle d-md-inline-block w-50" alt="">
                                    <div><?php echo nickName($note['userID']) ?></div>
                                    <div class="small text-grey ltr"><?php echo \Joonika\Idate\date_int("Y/m/d H:i:s", $note['datetime']); ?></div>
                                </div>
                                <div class="col-12 col-md-10">
                                    <?php
                                    if($note['type']=="note"){
                                    ?>
                                    <div class=""><?php echo $note['note'] ?></div>
                                    <?php
                                    }else{
//                                        echo $note['type'];
                                        if(function_exists('noteType_'.$note['type'])){
                                            call_user_func_array('noteType_'.$note['type'],[$note['id']]);
                                        }else{
                                            ?>
                                            <div class="alert alert-info"><?php echo $note['note'] ?></div>
                                        <?php
                                        }
                                    }
                                    $attachs=$database->select('crm_tickets_attachments','*',[
                                        "AND"=>[
                                            "ticketID"=>$ticketID,
                                            "noteID"=>$note['id'],
                                            ]
                                    ]);
                                    if(sizeof($attachs)>=1){
                                        ?>
                                        <div class="border-top border-info"><?php __e("attachments") ?></div>
                                        <?php
                                        foreach ($attachs as $attach){
                                            ?>
                                            <div class=""><?php
                                                $fileInfo=\Joonika\Upload\getFileInfo($attach['fileID']);
                                                if(isset($fileInfo['id'])){
                                                    ?>
                                                    <a target="_blank" href="<?php echo JK_DOMAIN_LANG ?>cp/crm/tickets/attach/<?php echo $note['id'].'-'.$fileInfo['id'].'-'.$attach['hash']; ?>"><?php echo $fileInfo['name']; ?></a>
                                                    <?php
                                                }
                                                ?></div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php
        }
    } else {
        echo alertWarning(__("no notes found"));
    }
}