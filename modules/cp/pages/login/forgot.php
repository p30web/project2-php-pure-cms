<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $database;
if (isset($_POST['usernameEmail'])) {
    $usercheck = $database->get('jk_users',['id','email','username','status'],[
        "OR"=>[
            "username"=>$_POST['usernameEmail'],
            "email"=>$_POST['usernameEmail'],
        ]
    ]);
    if(isset($usercheck['id'])){
        if($usercheck['status']=="active"){
$token=tokenGenerateUsers($usercheck['id']);

            $mail=emailSend(jk_options_get("defaultSendEmail"),$usercheck['email'],__('change password link'),emailTemplate("forgotLink",JK_LANG,[
                "link"=>JK_DOMAIN_LANG."cp/main/forgot/token/".$token,
                "nickname"=>\Joonika\Modules\Users\sexTitleUser($usercheck['id']).' '.nickName($usercheck['id']),
            ]));
            if($mail=="sent"){
                echo alertSuccess(__("forgot link address sent to your email").' : '.$usercheck['email']);
            }else{
                echo $mail;
            }
        }else{
            echo alertWarning(__("account is not active"));
        }
    }else{
        echo alertWarning(__("account not found"));
    }
}