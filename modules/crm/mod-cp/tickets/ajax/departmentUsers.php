<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $View;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}

            if (isset($_POST['department']) ) {
                $usfs=[];
                if($_POST['department']!=""){
                new \Joonika\Modules\Crm\Crm();
                    $usersF=\Joonika\Modules\Crm\ticketDepartmentFollowersUsers($_POST['department']);
                    $usfs=[];
                    if(sizeof($usersF[0])>=1){
                        foreach ($usersF[0] as $usf){
                            $usfs[$usf]=nickName($usf);
                        }
                    }

            }else{
                    $usfs=\Joonika\Modules\Users\usersArray();
                }
                echo \Joonika\Forms\field_select([
                    "name" => "owner",
                    "title" => __("assign to person"),
                    "ColType" => "12,12",
                    "first" => true,
                    "array" => $usfs,
                ]);
                echo $View->footer_js;
            }