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
    new \Joonika\Modules\Crm\Crm();
    if(isset($_POST['action'])){
        $action=$_POST['action'];
        if($action=="accept"){
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'open');
            \Joonika\Modules\Crm\ticketOwn($ticketID,JK_LOGINID);
        }elseif($action=="hold"){
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'hold');
        }elseif($action=="close"){
            $database->update("crm_tickets",[
                    "closedBy"=>JK_LOGINID,
                    "closedOn"=>date("Y/m/d H:i:s"),
            ],[
                    "id"=>$ticketID
            ]);
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'closed');
            echo redirect_to_js();
        }elseif($action=='forward'){
            $View->footer_js('<script>
$("#modal_global").modal("show");
 ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/forward',
                    "data" => '{ticketID:'.$ticketID.'}',
                    "success_response" => "#modal_global_body",
                    "loading" => [
                    ]
                ]) . '
</script>');
        }elseif($action=='forwardDep'){
            $View->footer_js('<script>
$("#modal_global").modal("show");
 ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/forwardDep',
                    "data" => '{ticketID:'.$ticketID.'}',
                    "success_response" => "#modal_global_body",
                    "loading" => [
                    ]
                ]) . '
</script>');
        }elseif($action=='addOrigin'){
            $View->footer_js('<script>
$("#modal_global").modal("show");
 ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/addOrigin',
                    "data" => '{ticketID:'.$ticketID.'}',
                    "success_response" => "#modal_global_body",
                    "loading" => [
                    ]
                ]) . '
</script>');
        }elseif($action=='sendConfirm'){
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'confirm');
            echo div_start("col-12");
            echo alertSuccess(__("confirmation sent to").' '.nickName($ticket['createdBy']));
            echo div_close();
        }elseif($action=='confirm'){
            $database->update("crm_tickets",[
                "closedBy"=>JK_LOGINID,
                "closedOn"=>date("Y/m/d H:i:s"),
            ],[
                "id"=>$ticketID
            ]);
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'closed',null,null,null,"confirmed");
            echo redirect_to_js();
        }elseif($action=='unConfirm'){
            \Joonika\Modules\Crm\ticketChangeStatus($ticketID,'open',null,null,null,"disapproval");
        }

        $ticket=$database->get('crm_tickets','*',[
            "id"=>$ticketID
        ]);
    };
    if($ticket['status']=="confirm" && $ticket['createdBy']==JK_LOGINID){
        echo div_start("col-12");
        echo alertWarning(__("this ticket awaiting for your confirmation"));
        echo div_close();
    }
    $btn_class=[
        "accept"=>"btn-outline-secondary disabled",
        "forward"=>"btn-outline-secondary disabled",
        "forwardDep"=>"btn-outline-secondary disabled",
        "sendConfirm"=>"btn-outline-secondary disabled",
        "confirm"=>"btn-outline-secondary disabled",
        "unConfirm"=>"btn-outline-secondary disabled",
        "hold"=>"btn-outline-secondary disabled",
        "addOrigin"=>"btn-outline-secondary disabled",
        "close"=>"btn-outline-secondary disabled",
    ];
    $btn_onclick=[
        "accept"=>"",
        "forward"=>"",
        "forwardDep"=>"",
        "sendConfirm"=>"",
        "confirm"=>"",
        "unConfirm"=>"",
        "hold"=>"",
        "addOrigin"=>"",
        "close"=>"",
    ];
    if($ticket['status']!='closed'){
    if($ticket['owner']=="" || $ticket['owner']!=JK_LOGINID || $ticket['status']=="hold"){
        $btn_onclick['accept']="ticketAction('accept')";
        $btn_class['accept']="btn-outline-success";
    }
    if($ticket['owner']==JK_LOGINID){
        $btn_onclick['forward']="ticketAction('forward')";
        $btn_class['forward']="btn-outline-info";
        $btn_onclick['forwardDep']="ticketAction('forwardDep')";
        $btn_class['forwardDep']="btn-outline-info";
        $btn_onclick['addOrigin']="ticketAction('addOrigin')";
        $btn_class['addOrigin']="btn-outline-info";
        if($ticket['status']!="confirm" && $ticket['createdBy']!=JK_LOGINID){
            $btn_onclick['sendConfirm']="ticketAction('sendConfirm')";
            $btn_class['sendConfirm']="btn-outline-info";
        }
        if($ticket['status']!="hold"){
            $btn_onclick['hold']="ticketAction('hold')";
            $btn_class['hold']="btn-outline-warning";
        }
        if($ticket['status']!="hold" && $ticket['status']!="confirm"){
            $btn_onclick['close']="ticketAction('close')";
            $btn_class['close']="btn-outline-danger";
        }
    }
        if($ticket['status']=="confirm" && $ticket['createdBy']==JK_LOGINID ){
            $btn_onclick['confirm']="ticketAction('confirm')";
            $btn_class['confirm']="btn-outline-success";
            $btn_onclick['unConfirm']="ticketAction('unConfirm')";
            $btn_class['unConfirm']="btn-outline-danger";
        }



    }
?>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['accept']; ?>" onclick="<?php echo $btn_onclick['accept']; ?>" id="ticketAction_accept"><i class="fa fa-check-double float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("accept review"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['forward']; ?>" onclick="<?php echo $btn_onclick['forward']; ?>" id="ticketAction_forward"><i class="fa fa-forward float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("assign ticket to other"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['forwardDep']; ?>" onclick="<?php echo $btn_onclick['forwardDep']; ?>" id="ticketAction_forwardDep"><i class="fa fa-building float-right pt-1 d-none d-md-inline-block"></i><i class="fa fa-forward float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("assign ticket to other department"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['hold']; ?>" onclick="<?php echo $btn_onclick['hold']; ?>" id="ticketAction_hold"><i class="fa fa-pause float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("holding ticket"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['sendConfirm']; ?>" onclick="<?php echo $btn_onclick['sendConfirm']; ?>" id="ticketAction_sendConfirm"><i class="fa fa-check float-right pt-1 d-none d-md-inline-block"></i><i class="fa fa-forward float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("send confirmation"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['confirm']; ?>" onclick="<?php echo $btn_onclick['confirm']; ?>" id="ticketAction_confirm"><i class="fa fa-check float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("confirm finish"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['unConfirm']; ?>" onclick="<?php echo $btn_onclick['unConfirm']; ?>" id="ticketAction_unConfirm"><i class="fa fa-check float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("disapproval finish"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['addOrigin']; ?>" onclick="<?php echo $btn_onclick['addOrigin']; ?>" id="ticketAction_addOrigin"><i class="fab fa-osi float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("add origin"); ?></button>
<button type="button" class="col-12 col-md-12 btn btn-sm <?php echo $btn_class['close']; ?>" onclick="<?php echo $btn_onclick['close']; ?>" id="ticketAction_close"><i class="fa fa-power-off float-right pt-1 d-none d-md-inline-block"></i> <?php echo __("close ticket"); ?></button>
<?php

}

echo $View->footer_js;