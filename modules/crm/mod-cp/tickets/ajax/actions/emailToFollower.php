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

    if (isset($_POST['fid'])) {
        $dataget=$database->get('crm_tickets_followers','*',[
            "id"=>$_POST['fid']
        ]);
        if(isset($dataget['id'])){
//            echo $dataget['userID'];
         $userEmail=$database->get('jk_users',['email'],[
             "id"=>$dataget['userID']
         ]);
         if(isset($userEmail['email']) && $userEmail['email']!=""){
             $txt='';
             $txt.=__("one ticket need your review").'<br/>';
             $txt.=__("ticket id").' : '.$ticketID.'<br/>';
             $txt.=__("ticket title").' : '.$ticket['title'].'<br/>';
             $emailst=emailSend("crm@ipinbar.net","mnajdidi@gmail.com",__("review ticket No.").' '.$ticketID,$txt);
             if($emailst=="sent"){
                 echo '<script>
swal(
  \''.__("email sent successfully").'\',
  \''.__("email").': '.$userEmail['email'].'\',
  \'success\'
)
</script>';
             }
         }
        }
    }
}