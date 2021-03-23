<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
global $View;
global $database;
        $CountsOpenGeneral=$database->count('crm_tickets',[
            "AND"=>[
                "status[!]"=>"closed",
                "global"=>"1",
            ]
        ]);
        $getFollows=$database->select('crm_tickets_followers','ticketID',[
            "AND"=>[
                "status"=>"active",
                "userID"=>JK_LOGINID,
            ]
        ]);
        if(sizeof($getFollows)==0){
            $getFollows=0;
        }
            $CountsOpen=$database->count('crm_tickets',[
                "AND"=>[
                    "id"=>$getFollows,
                    "status"=>["open","new"],
                ]
            ]);
$CountsAll=$database->count('crm_tickets',[
                "OR"=>[
                    "id"=>$getFollows,
                    "global"=>1,
                ]
            ]);
$CountsMy=$database->count('crm_tickets',[
                "AND"=>[
                    "id"=>$getFollows,
                    "owner"=>JK_LOGINID,
                    "status"=>["open","new"],
                ]
            ]);

            $getUnreadFollows=$database->select('crm_tickets_followers','ticketID',[
                "AND"=>[
                    "userID"=>JK_LOGINID,
                    "read[!]"=>1,
                ]
            ]);
$CountsUnread=$database->count('crm_tickets',[
                "AND"=>[
                    "id"=>$getUnreadFollows,
                    "status"=>["open","new"],
                ]
            ]);
$View->footer_js('<script>
if($("#types_allTickets_flag").length){
    $("#types_allTickets_flag").html("<span class=\'badge badge-pill badge-secondary\'>'.$CountsAll.'</span>");
}
if($("#types_openTickets_flag").length){
    $("#types_openTickets_flag").html("<span class=\'badge badge-pill badge-secondary\' style=\'background-color:#191970\'>'.$CountsOpen.'</span>");
}
if($("#types_openGeneralTickets_flag").length){
    $("#types_openGeneralTickets_flag").html("<span class=\'badge badge-pill badge-info\'>'.$CountsOpenGeneral.'</span>");
}
if($("#types_myTickets_flag").length){
    $("#types_myTickets_flag").html("<span class=\'badge badge-pill badge-success\'>'.$CountsMy.'</span>");
}
if($("#types_unreadTickets_flag").length){
    $("#types_unreadTickets_flag").html("<span class=\'badge badge-pill badge-danger\'>'.$CountsUnread.'</span>");
}

</script>');
echo $View->footer_js;
